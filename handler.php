<?php
require_once dirname(__FILE__).'/'."tsk/Skill.php";
require_once dirname(__FILE__).'/'."tsk/SkillRsp.php";
require_once dirname(__FILE__).'/'."config.php";
require_once dirname(__FILE__).'/'."dkconfig.php";
require_once dirname(__FILE__).'/'."game/GameConst.php";
require_once dirname(__FILE__).'/'."game/GameCache.php";
require_once dirname(__FILE__).'/'."game/Language.php";

// 加载游戏代码
require_once "csz/handler.php";

// 根据游戏处理
function request_game_hander($body, $gameType, $request_type, $cache)
{
	global $config;
	$dkconfig = $config['dkconfig'];
	
	// 根据游戏类型处理
	switch ($gameType) {
		case GAMETYPE_CSZ:
			return request_game_hander_csz($body, $request_type, $cache);
	}
	// 未知错误
	log_error("未知游戏类型: " . $gameType);
	return build_skill_failed_response($dkconfig, "error", true);
}

// 处理接口
function request_hander($body, $request_type, $cache)
{
	global $config;
	$dkconfig = $config['dkconfig'];
	
	// 非退出请求
	if ($request_type != "SessionEndedRequest") {
		// 通用退出
		if ($body->request->queryText == "不玩了") {
			log_debug("exit game 1");
			$successSpeach = array(
				"type" => "PlainText",
				"text" => Language::GameExit_Voice,
			);
			$successText = array(
				'title' => "",		//显示标题
				'description' => Language::GameExit_Text, // 显示内容
			);
			return build_skill_success_response($dkconfig, $successSpeach, $successText, true);
		}
		
		
		// 根据状态判断
		if ($cache->state == STATE_NULL || $cache->state == STATE_EXIT) {
			$cache->state = STATE_SELECT;	//标记为选择状态
			log_debug("change state 0 : " . $cache->state);
			// 尚未开始游戏, 询问开始哪个游戏
			$successSpeach = array(
				"type" => "PlainText",
				"text" => Language::GameStart_Voice,
			);
			$successText = array(
				'title' => "",		//显示标题
				'description' => Language::GameStart_Text, // 显示内容
			);
			// var_dump($successSpeach);
			// var_dump($successText);
			return build_skill_success_response($dkconfig, $successSpeach, $successText, false);
		} else if ($cache->state == STATE_SELECT) {
			log_debug("change state 1");
			// 选项比对
			$selectMode = 0;
			foreach (GameConst::$GAMETYPE_NAMES as $key => $value) {
				log_debug("check[" . $key . "] :" . $body->request->queryText . " -> " . $value);
				if ($body->request->queryText == $value) {
					$selectMode = $key + 1;	// 模式为1开头
					break;
				}
			}
			// 判断选择
			if ($selectMode <= 0) {
				// 回答错误, 重新问一下.
				$speach = array(
					"type" => "PlainText",
					"text" => Language::GameStart_Voice,
				);
				$text = array(
					'title' => "",		//显示标题
					'description' => Language::GameStart_Text, // 显示内容
				);
				return build_skill_success_response($dkconfig, $speach, $text, false);
			}
			log_debug("change state 2");
			
			// 选择成功
			$cache->gameType = $selectMode;
			$cache->state = STATE_START;	// 标记为开始状态
			return request_game_hander($body, $cache->gameType, $request_type, $cache);
		} else {
			// 开始游戏/ 游戏中/结束游戏状态
			
			// 判断游戏模式
			if ($cache->gameType == GAMETYPE_NULL) {
				$cache->state = STATE_SELECT;	//标记为选择状态
				// 回答错误, 重新问一下.
				$speach = array(
					"type" => "PlainText",
					"text" => Language::GameStart_Voice,
				);
				$text = array(
					'title' => "",		//显示标题
					'description' => Language::GameStart_Text, // 显示内容
				);
				return build_skill_success_response($dkconfig, $speach, $text, false);
			}
			
			// 进行游戏逻辑处理
			return request_game_hander($body, $cache->gameType, $request_type, $cache);
		}
	} else {
		// session 断开
		$cache->state = STATE_NULL;
		$successSpeach = array(
			"type" => "PlainText",
			"text" => Language::GameExit_Voice,
		);
		$successText = array(
			'title' => "",		//显示标题
			'description' => Language::GameExit_Text, // 显示内容
		);
		return build_skill_success_response($dkconfig, $successSpeach, $successText, true);
	}
	
	// 无法识别提示
	return build_skill_failed_response($dkconfig, "skillIdInvalid", false);


	// switch ($request_type) {
	// 	case "LaunchRequest":
	// 		break;
	// 	case "IntentRequest":
	// 		break;
	// 	case "SessionEndedRequest":
	// 		break;
	// 	case "RetryIntentRequest":
	// 		break;
	// 	default:
	// 		break;
	// }

	// $r = rand(0, 100);
	// $text = "你好" . $r;
	// $successSpeach = array(
	// 	"type" => "PlainText",
	// 	"text" => $text,
	// );
	// $successText = array(
	// 	'title' => "",		//显示标题
	// 	'description' => $text // 显示内容
	// );
	// return build_skill_success_response($dkconfig, $successSpeach, $successText);
}

// 头转字符串
function headers_str($header)
{
	// var_dump($header);
	$header_str = "";
	foreach ($header as $key => $value) {
		$header_str = $header_str . $key . ":" . $value . ";";
	}
	return $header_str;
}

function request($headers, $body)
{
	global $config;
    // var_dump($config["debug"]);
	if ($config["debug"]) {
    	// 测试代码
		$request_file = read_file("test_request.txt");
		if ($request_file != "") {
			$body = $request_file;
		}
		log_info("body: " . $body . " test:" . $request_file);
	}
	
	// 检测内容
	if (!isset($body) || $body == null || $body == "") {
		log_error("no body! ");
		return null;
	}
    
    // 请求内容json解析
    // var_dump($body);
	$body_json = json_decode($body);
    // var_dump($body_json);
    
    
    // 输出基本内容
	log_info("json: " . json_encode($body_json));
	// log_info("deviceId: " . $body_json->context->System->device->deviceId);
    // $deviceId = $body_json['device']['deviceId'];
    // log_info("deviceId: " . $deviceId);
    
    
    // TODO 基础校验, 认证是否是我们的技能
    
    
    // TODO session数据提取
	session_id($body_json->context->System->device->deviceId);
	session_start();
	$cache_str = isset($_SESSION['cache']) ? $_SESSION['cache'] : "";
	$cache = new GameCache(json_decode($cache_str));
	log_info("game cache read: " . $cache_str);
	
	 // TODO 永久数据读取
	
    // TODO 识别请求内容进行处理
	$result = request_hander($body_json, $body_json->request->type, $cache);
    
    // TODO 保存session内容
	$cache_str = json_encode($cache);
	$_SESSION['cache'] = $cache_str;
	log_info("game cache save: " . $cache_str);
    
    // TODO 返回处理内容
	return array(
		"header" => headers_str($result["header"]),
		"body" => json_encode($result["body"]),
	);
}




?>
