<?php

require_once "Const.php";
require_once "SkillReq.php";
require_once "SkillRsp.php";
require_once "Language.php";
require_once "Game.php";
require_once "ct/CtGame.php";

// 叮当技能
class Skill extends App
{
    const CACHE_TIMEOUT = 15;   // cache超时时间 15s
    protected $body;    // 请求数据对象
    protected $game;    // 游戏

    // 技能状态(public属性才能打入json)
    public $state;  // 当前状态
    public $gameType;   // 选择的游戏模式
    public $gameState;  // 游戏状态
    public $prevTime;   // 上次处理时间

    public function __construct($config)
    {
        parent::__construct($config);
        $this->state = STATE_NULL;
        $this->gameType = GAMETYPE_NULL;
        $this->gameState = GAMESTATE_NULL;
        $this->prevTime = 0;
    }
    
    // 初始化(每次请求)
    protected function init()
    {
        // 父类初始化
        if (!parent::init()) {
            return false;
        }
        
        // json格式转化
        $this->body = json_decode($this->context);
        if (empty($this->body)) {
            log_error("body is empty! context:" . $this->context);
            return false;
        }
        // $this->body = new SkillReq($context);
        log_info("body: " . json_encode($this->body));
        
        // session开始
        $deviceId = !empty($this->body->context->System->device->deviceId) ? $this->body->context->System->device->deviceId : 0;
        $sessionId = md5($deviceId);
        session_id($sessionId);
        session_start();
        
        // cache记录
        $cache_str = !empty($_SESSION['cache']) ? $_SESSION['cache'] : "";
    
        // 检测超时
        // $prev_time = (!empty($_SESSION['prev_time'])) ? $_SESSION['prev_time'] : 0;
        // $now_time = time();
        // $dt = $now_time - $prev_time;
        // if ($dt > Skill::CACHE_TIMEOUT) {
        //     log_debug("timeout clean cache! " . $dt . "(" . $prev_time . "/" . $now_time . ") ");
        //     $cache_str = "";	// 清除缓存
        // }
        // $_SESSION['prev_time'] = $now_time;
        
        // cache解析
        json_decode_object($this, $cache_str);

        // game 解析
        $game_str = !empty($_SESSION['game']) ? $_SESSION['game'] : "";
        if (!empty($game_str) && !empty($this->gameType)) {
            $this->game = $this->createGame($this->gameType);
            json_decode_object($this->game, $game_str);
        }

        log_info("session: " . $sessionId . " cache: " . $cache_str . " game: " . $game_str);

        return true;
    }


    protected function finish($result)
    {
        // 记录请求时间
        $this->prevTime = time();
        
        // session game保存
        if (!empty($this->game)) {
            $game_str = json_encode($this->game);   // protected 属性不会打入内
            $_SESSION['game'] = $game_str;
        }
        
        // session cache保存
        $cache_str = json_encode($this);
        $_SESSION['cache'] = $cache_str;

        parent::finish($result);
    }
    
    // 游戏请求
    protected function createGame($gameType)
    {
        if ($gameType == GAMETYPE_CT) {
            return new CtGame($this, $gameType);
        }

        // return new Game($this, $gameType);
        return null;
    }
    
    // 请求操作
    protected function request()
    {
        $request_type = $this->body->request->type;
        // echo "request_type: $request_type";
        // 退出请求
        if ($request_type == "SessionEndedRequest" || Language::checkExitInput($this->body->request)) {
            // session 断开
            $this->state = STATE_NULL;
            return $this->response(SkillRsp::Build(Language::GameExit_Voice, Language::GameExit_Text, true));
        }
    
        // 正常访问
        // 根据状态判断
        if ($this->state == STATE_NULL || $this->state == STATE_EXIT) {
            $this->state = STATE_SELECT;	//标记为选择状态
            log_debug("change state 0 : " . $this->state);
            return $this->response(SkillRsp::Build(Language::GameStart_Voice, Language::GameStart_Text . Language::getGameListText(), false));
        } else if ($this->state == STATE_SELECT) {
            log_debug("change state 1");
			// 选项检测
            $selectIndex = -1;
            
            // 直接选项名字比对
            $selectIndex = Language::checkInputByTexts($this->body->request->queryText, GameConst::$GAMETYPE_NAMES);
            if ($selectIndex < 0) {
                // 识别选项
                $selectIndex = Language::checkSelectInput($this->body->request, count(GameConst::$GAMETYPE_NAMES));
            }
            log_debug("change state 2, select:" . $selectIndex);
            
			// 判断选择
            if ($selectIndex < 0) {
				// 回答错误, 重新问一下.
                return $this->response(SkillRsp::Build(Language::GameUnknow_Voice, Language::GameUnknow_Text . Language::getGameListText(), false));
            }
            log_debug("change state 3");
			
			// 选择成功
            $this->gameType = $selectIndex + 1; //模式 1~N
            $this->state = STATE_START;	// 标记为开始状态
            $this->game = $this->createGame($this->gameType);
            if ($this->game == null) {
                log_error("create game by type fail! type=" . $this->gameType);
                return $this->response(SkillRsp::Build(Language::AppError_Voice, Language::AppError_Text, true));
            }
            
            // return request_game_hander($this->body, $this->gameType, $request_type, $this);
            return $this->game->request();
        } else {
			// 开始游戏/游戏中/结束游戏状态
			// 判断游戏模式
            if (empty($this->game)) {
                log_debug("game is empty!");
                $this->state = STATE_SELECT;	//标记为选择状态
                return $this->response(SkillRsp::Build(Language::GameUnknow_Voice . "" . Language::getGameListText(), Language::GameStart_Text . Language::GameLgetGameListText(), false));
            }
            // 处理请求
            return $this->game->request();
        }

        // return $this->responseNoFind();
        return $this->response(SkillRsp::Build("猜一猜测试", "猜一猜测试", true));
    }

    public function getBody()
    {
        return $this->body;
    }
};




?>