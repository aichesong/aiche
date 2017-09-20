﻿(function (e)
{
    try
    {
        if (typeof(hex_md5) == "undefined")
        {
            document.write('<script type="text/javascript" src="../js/im/MD5.min.js"><\/script>')
        }
    } catch (e)
    {
        document.write('<script type="text/javascript" src="../js/im/MD5.min.js"><\/script>')
    }
    try
    {
        if (!Base64 || typeof(Base64) == "undefined")
        {
            document.write('<script type="text/javascript" src="../js/im/base64.min.js"><\/script>')
        }
    } catch (e)
    {
        document.write('<script type="text/javascript" src="../js/im/base64.min.js"><\/script>')
    }
    try
    {
        if (!jQuery || typeof(jQuery) == "undefined")
        {
            document.write('<script type="text/javascript" src="../js/im/jquery-1.11.3.min.js"><\/script>')
        }
    } catch (e)
    {
        document.write('<script type="text/javascript" src="../js/im/jquery-1.11.3.min.js"><\/script>')
    }
    try
    {
        if (!pako || typeof(pako) == "undefined")
        {
            document.write('<script type="text/javascript" src="../js/im/pako.js"><\/script>')
        }
    } catch (e)
    {
        document.write('<script type="text/javascript" src="../js/im/pako.js"><\/script>')
    }
    var YTX_CONFIG = {
        getServer: true,
        _app_server: "aHR0cHM6Ly9pbXNsYi55dW50b25neHVuLmNvbS8yMDE2LTA4LTE1L0hUTUw1Lw==",
        _lvs_servers: null,
        _server_ip: null,
        _file_server_url: null,
        _socket: null,
        _appid: '',
        _version: '5.2.2',
        _ClientNo: 0,
        _msgVersion: 0,
        _syncMsgVersion: 0,
        _routerSwitch: true,
        _maxMsgVersion: 0,
        _syncMsgPorcessing: false,
        _receiveMsgBuf: [],
        _loginMode: 1,
        _network: 1,
        _sdkName: 'YTX-HTML5-SDK',
        _token: null,
        _userName: null,
        _userPwd: null,
        _imei: null,
        _clientMap: {},
        _loginStatus: 1,
        _isConnect: false,
        _mcm_agentId: null,
        _ccpCustomData: null,
        _deviceType: 21,
        _timeOutSecond: 40,
        _fileTimeOutSecond: 120,
        _heartBeatInterval: {_2G: 45, _3G: 90, _4G: 180, _WIFI: 300, _RECONNECT: 15},
        _failHeartBeatInterval: 10,
        _heartBeatTimeOut: 5,
        _intervalId: null,
        _failIntervalId: null,
        _isConnecting: false,
        _reLoginNum: 0,
        _isReconnect: false,
        _currentSession: 0,
        _maxMsgLen: 2048,
        _maxFileLen: 1024 * 1024 * 50,
        _loginType: 1,
        _sessionId: null,
        _fileSig: null,
        _pushListener: null,
        _noticeListener: null,
        _mcmListener: null,
        _mcmNoticeListener: null,
        _connectStatListener: null,
        _voipListener: null,
        _msgNotifyListener: null,
        _heartBeatErrNum: 0,
        _Notification: null,
        _beforeUnLoad: [],
        _voipTimestamp: 0,
        _voipTimer: null,
        _logLev: {_DEBUG: 1, _INFO: 2, _WARN: 3, _ERROR: 4},
        _logLevStat: 1,
        _tel: null,
        _nickname: null,
        _log: function (lev, content)
        {
            if (lev < YTX_CONFIG._logLevStat)
            {
                return
            }
            if (!window.console || !window.console.log || !window.console.info || !window.console.warn || !window.console.error)
            {
                return
            }
            var timeStamp = YTX_CONFIG._getTimeStamp();
            content = timeStamp + " :: SDK :: " + content;
            if (lev == YTX_CONFIG._logLev._DEBUG)
            {
                console.log(content)
            }
            else if (lev == YTX_CONFIG._logLev._INFO)
            {
                console.info(content)
            }
            else if (lev == YTX_CONFIG._logLev._WARN)
            {
                console.warn(content)
            }
            else if (lev == YTX_CONFIG._logLev._ERROR)
            {
                console.error(content)
            }
        },
        _WS_TYPE: 4,
        _ipSpeedTestConfig: {
            _count: 10,
            _interval: 1000,
            _timeout: {
                _3G: 10 * 1000,
                _WIFI: 5 * 1000,
                _LAN: 1 * 1000,
                _4G: 3 * 1000,
                _GPRS: 20 * 1000,
                _OTHER: 10 * 1000
            }
        },
        _prototype: {
            _ipSpeedTest: 5,
            _kickOff: 6,
            _msg_CMD: 9,
            _msg_DEL: 21,
            _confirmMsg: 15,
            _pushMsgNotify: 18,
            _pushMsg: 19,
            _login: 20,
            _logout: 21,
            _setMyInfo: 23,
            _getMyInfo: 24,
            _syncMsg: 27,
            _sendMsg: 29,
            _createGroup: 30,
            _dismissGroup: 31,
            _quitGroup: 32,
            _joinGroup: 33,
            _confirmJoinGroup: 34,
            _inviteJoinGroup: 35,
            _getGroupDetail: 36,
            _getOwnGroups: 37,
            _forbidMemberSpeak: 38,
            _modifyGroup: 39,
            _confirmInviteJoin: 40,
            _searchGroups: 41,
            _queryGroupMembers: 42,
            _deleteGroupMember: 43,
            _queryGroupMemberCard: 44,
            _modifyMemberCard: 45,
            _setGroupMessageRule: 46,
            _mcmEventData: {
                _prototype: 126,
                _mcmEventDef: {
                    _UserEvt_StartAsk: 1,
                    _UserEvt_EndAsk: 2,
                    _UserEvt_SendMSG: 3,
                    _UserEvt_SendMail: 4,
                    _UserEvt_SendWXMsg: 5,
                    _UserEvt_GetAGList: 6,
                    _UserEvt_RespAGList: 7,
                    _UserEvt_IRCN: 8,
                    _UserEvt_SendMCM: 9,
                    _NotifyUser_QueueInfo: 10,
                    _NotifyUser_StartAskResp: 11,
                    _NotifyUser_EndAskResp: 12,
                    _NotifyUser_StartConf: 13,
                    _NotifyUser_StopConf: 14,
                    _NotifyUser_EndAsk: 15,
                    _NotifyUser_IRItemList: 16,
                    _UserEvt_SelectItem: 17,
                    _NotifyUser_StartRobotKF: 18,
                    _NotifyUser_StopRobotKF: 19,
                    _AgentEvt_KFOnWork: 47,
                    _NotifyAgent_KFOnWorkResp: 48,
                    _AgentEvt_KFOffWork: 49,
                    _NotifyAgent_KFOffWorkResp: 50,
                    _AgentEvt_KFStateOpt: 51,
                    _NotifyAgent_KFStateResp: 52,
                    _AgentEvt_SendMCM: 53,
                    _AgentEvt_TransKF: 55,
                    _NotifyAgent_TransKFResp: 56,
                    _AgentEvt_EnterCallService: 57,
                    _NotifyAgent_EnterCallSerResp: 58,
                    _NotifyAgent_NewUserAsk: 59,
                    _NotifyAgent_UserEndAsk: 60,
                    _NotifyAgent_ImHistory: 61,
                    _AgentEvt_Ready: 65,
                    _AgentEvt_NotReady: 66,
                    _AgentEvt_StartSerWithUser: 67,
                    _AgentEvt_StopSerWithUser: 68,
                    _AgentEvt_TransferQueue: 69,
                    _AgentEvt_StartConf: 70,
                    _AgentEvt_MakeCall: 71,
                    _AgentEvt_AnswerCall: 72,
                    _AgentEvt_ReleaseCall: 73,
                    _AgentEvt_SendNotify: 74,
                    _AgentEvt_ExitConf: 75,
                    _NotifyAgent_NewUserCallin: 76,
                    _NotifyAgent_UserReleaseCall: 77,
                    _NotifyAgent_ReadyResp: 78,
                    _NotifyAgent_NotReadyResp: 79,
                    _NotifyAgent_UserCallEstablish: 80,
                    _AgentEvt_RejectUser: 81,
                    _NotifyAgent_RejectUserResp: 82,
                    _NotifyAgent_StartConfResp: 83,
                    _NotifyAgent_ExitConfResp: 84,
                    _NotifyAgent_ExitConf: 85,
                    _NotifyAgent_InviteJoinConf: 86,
                    _AgentEvt_ForceJoinConf: 87,
                    _NotifyAgent_ForceJoinConfResp: 88,
                    _NotifyAgent_TransferNewUser: 89,
                    _NotifyAgent_TransferQueueResp: 90,
                    _NotifyAgent_ForceStartConf: 91,
                    _AgentEvt_ForceTransfer: 92,
                    _NotifyAgent_ForceTransferResp: 93,
                    _NotifyAgent_ForceTransfernewUser: 94,
                    _NotifyAgent_CallState: 95,
                    _NotifyAgent_StopSerWithUserResp: 96,
                    _AgentEvt_QueryQueueInfo: 97,
                    _NotifyAgent_QueryQueueInfoResp: 98,
                    _NotifyAgent_StartSerWithUserResp: 99,
                    _AgentEvt_ReservedForUser: 100,
                    _NotifyAgent_ReservedForUserResp: 101,
                    _AgentEvt_CancelReserved: 102,
                    _NotifyAgent_CancelReservedResp: 103,
                    _NotifyAgent_ReservedUserAsk: 104,
                    _AgentEvt_StartSessionTimer: 105,
                    _NotifyAgent_StartSessionTimerResp: 106,
                    _NotifyAgent_STExpired: 107,
                    _AgentEvt_MonitorAgent: 108,
                    _NotifyAgent_MonitorAgentResp: 109,
                    _AgentEvt_CancelMonitorAgent: 110,
                    _NotifyAgent_CancelMonitorAgentResp: 111,
                    _AgentEvt_QueryAgentInfo: 112,
                    _NotifyAgent_QueryAgentInfoResp: 113,
                    _AgentEvt_SerWithTheUser: 114,
                    _NotifyAgent_SerWithTheUserResp: 115,
                    _AgentEvt_TransKFStartSerWithUser: 116,
                    _AgentEvt_ForceTransferStartSerWithUser: 117,
                    _AgentEvt_ForceEndService: 118,
                    _NotifyAgent_ForceEndService: 119,
                    _NotifyUser_ForceEndService: 120,
                    _NotifyAgent_ForceEndServiceResp: 121,
                    _NotifyAgent_JoinConfResp: 122,
                    _AgentEvt_JoinConf: 123,
                    _NotifyAgent_AgentSendMsg: 124,
                    _NotifyUser_SendMSGResp: 125,
                    _NotifyAgent_SendMCMResp: 126,
                    _NotifyAgent_AgentJoinIM: 127,
                    _NotifyAgent_AgentEndIMService: 128,
                    _NotifyAgent_ExitIMService: 129,
                    _NotifyAgent_TransferResult: 130
                },
                _mcmType: {
                    _MCMType_txt: 1,
                    _MCMType_audio: 2,
                    _MCMType_video: 3,
                    _MCMType_emotion: 4,
                    _MCMType_pos: 5,
                    _MCMType_file: 6
                },
                _mcmAgentState: {
                    _AgentTelStat_noready: 0,
                    _AgentTelStat_idle: 1,
                    _AgentTelStat_locking: 2,
                    _AgentTelStat_talking: 3,
                    _AgentTelStat_linebusy: 4,
                    _AgentTelStat_offwork: 9,
                    _AgentImStat_offline: 10,
                    _AgentImStat_online: 11,
                    _AgentImStat_idle: 12,
                    _AgentImStat_offwork: 13,
                    _AgentImStat_working: 14,
                    _AgentImStat_workingfull: 15,
                    _AgentImStat_suspend: 16
                },
                _mcmChannel: {_MCType_im: 0, _MCType_wx: 1, _MCType_mail: 2, _MCType_sms: 3, _MCType_fax: 4}
            },
            _getUserState: 71,
            _callRoute: 127,
            _deleteReadMsg: 72,
            _msgOperation: 72,
            _setGroupMemberRole: 74
        },
        _httpType: {_attachStart: 1, _attachEnd: 2, _historyMessage: 3, _recentContact: 4, _userDevice: 5},
        _voipCallData: {
            _iceServers: [],
            _peerConnection: null,
            _callEventCallId: null,
            _called: null,
            _caller: null,
            _inviteSdp: null,
            _voipOtherView: null,
            _voipLocalView: null,
            _localMediaStream: null,
            _connected: false,
            _voipCallType: null,
            _msgRouterMap: {},
            _releaseCallback: null,
            _releaseCallbackError: null
        },
        _errcode: {
            _SUCC: 200,
            _NO_LOGIN: 170003,
            _NOT_SUPPORT_H5: 174001,
            _NO_REQUIRED_PARAM: 170002,
            _PARAM_TYPE_ERR: 170012,
            _NETWORK_ERR: 174002,
            _NETWORK_TIME_OUT: 174003,
            _FILE_PARAM_ERROR: 170012,
            _RESP_TIME_OUT: 171137,
            _LOGIN_NO_USERNAME: 170002,
            _LOGIN_NO_PWD: 170002,
            _GROUP_NO_GROUPID: 170002,
            _TEXT_TOO_LONG: 170001,
            _FILE_TOO_LARGE: 170001,
            _PARAM_OUT_OF_LENGTH: 170001,
            _VOIP_NO_MEDIA: 174004,
            _VOIP_MEDIA_ERROR: 174005,
            _VOIP_NO_VIDEO: 170002,
            _REQUEST_TOO_FREQUENT: 174006,
            _CHARSET_ILLEGAl: 170012,
            _NOT_SUPPORT_FILE: 174007,
            _NOT_SUPPORT_CALL: 174008,
            _NOT_SUPPORT_URL: 174009,
            _NO_RESOURCE_STREAM: 174010,
            _FILE_SOURCE_ERROR: 174011,
            _FILE_FILEREADER_ERROR: 174012
        },
        _requestTime: null,
        _requestCounter: 0,
        _requestLimit: 300,
        _synMsgMaxNumLimit: 100,
        _newUserState: false,
        _deleteReadMsgMap: {},
        _groupConfig: {_groupArray: [], _groupMemberArray: [], _builder: null},
        _sendMsg: function (content)
        {
            var curTime = new Date().getTime();
            if (!YTX_CONFIG._requestTime)
            {
                YTX_CONFIG._requestTime = curTime;
                YTX_CONFIG._requestCounter = 0
            }
            else if ((curTime - YTX_CONFIG._requestTime) > 60 * 1000)
            {
                YTX_CONFIG._requestTime = curTime;
                YTX_CONFIG._requestCounter = 0
            }
            if (YTX_CONFIG._requestCounter++ < YTX_CONFIG._requestLimit)
            {
                YTX_CONFIG._log(YTX_CONFIG._logLev._INFO, "send msg : " + content);
                YTX_CONFIG._socket.send(content)
            }
            else
            {
                var json = JSON.parse(content);
                var msgLite = json["MsgLite"];
                var clientNo = msgLite["3"];
                var request = YTX_CONFIG._clientMap[clientNo];
                try
                {
                    clearTimeout(request.timeout)
                } catch (e)
                {
                    console.log("Cannot read property 'timeout' of undefined")
                }
                ;
                var onError = request.onError;
                var resp = {};
                resp.code = YTX_CONFIG._errcode._REQUEST_TOO_FREQUENT;
                resp.msg = 'request too quick, please wait a minute.';
                onError(resp)
            }
        },
        _generateClientNo: function (callback, onError, msgId, endVersion, type, repeat, orignMsgId, notUpdate)
        {
            var clientNo;
            if (notUpdate)
            {
                clientNo = YTX_CONFIG._ClientNo
            }
            else
            {
                clientNo = ++YTX_CONFIG._ClientNo
            }
            var data = {};
            if (!!callback)
            {
                data.callback = callback
            }
            else
            {
                data.callback = function ()
                {
                }
            }
            data.onError = onError;
            if (!!msgId)
            {
                data.msgId = msgId
            }
            if (!!endVersion)
            {
                data.endVersion = endVersion
            }
            if (!!type)
            {
                data.type = type
            }
            if (!!repeat)
            {
                data.repeat = repeat
            }
            if (!!orignMsgId)
            {
                data.orignMsgId = orignMsgId
            }
            var i = setTimeout(function ()
            {
                var resp = {};
                if (YTX_CONFIG._loginStatus == 2)
                {
                    YTX_CONFIG._loginStatus = 1
                }
                resp.code = YTX_CONFIG._errcode._RESP_TIME_OUT;
                if (!!orignMsgId)
                {
                    resp.msgId = orignMsgId
                }
                if (!!msgId)
                {
                    resp.msgClientNo = msgId
                }
                resp.msg = 'request time out.', onError(resp);
                console.log('time out clientNo is: ' + clientNo);
                delete YTX_CONFIG._clientMap[clientNo]
            }, YTX_CONFIG._timeOutSecond * 1000);
            data.timeout = i;
            YTX_CONFIG._clientMap[clientNo] = data;
            return clientNo
        },
        _noticeApp: function (obj)
        {
            var msgId = obj.msgDateCreated + '|' + obj.version;
            obj.msgId = msgId;
            if (obj.msgType == YTX_CONFIG._prototype._msg_CMD)
            {
                var resp = YTX_CONFIG._protobuf._parseNoticeMsg(obj);
                resp.msgId = obj.msgId;
                if (!!YTX_CONFIG._noticeListener)
                {
                    YTX_CONFIG._noticeListener(resp)
                }
                else
                {
                    YTX_CONFIG._log(YTX_CONFIG._logLev._INFO, "noticeLinstener is null   ")
                }
            }
            else if (obj.msgType == YTX_CONFIG._prototype._msg_DEL)
            {
                console.log("阅后即焚删除消息");
                if (!!YTX_CONFIG._deleteReadMsgMap[JSON.parse(obj.msgDomain)["msgid"]])
                {
                    setTimeout(function ()
                    {
                        delete YTX_CONFIG._deleteReadMsgMap[JSON.parse(obj.msgDomain)["msgid"]];
                        console.log(YTX_CONFIG._deleteReadMsgMap)
                    }, 10000);
                    return
                }
                var resp = YTX_CONFIG._protobuf._parseMsgNotify(obj);
                if (!!YTX_CONFIG._msgNotifyListener)
                {
                    YTX_CONFIG._msgNotifyListener(resp)
                }
                else
                {
                    YTX_CONFIG._log(YTX_CONFIG._logLev._INFO, "_msgNotifyListener is null : ")
                }
            }
            else if (obj.mcmEvent != 0)
            {
                if (!!YTX_CONFIG._mcmListener)
                {
                    YTX_CONFIG._mcmListener(obj)
                }
                else
                {
                    YTX_CONFIG._log(YTX_CONFIG._logLev._INFO, "_mcmListener is null : ")
                }
            }
            else
            {
                if (!!YTX_CONFIG._pushListener)
                {
                    YTX_CONFIG._pushListener(obj)
                }
                else
                {
                    YTX_CONFIG._log(YTX_CONFIG._logLev._INFO, "_pushListener is null : ")
                }
            }
        },
        _processSyncMsg: function (type, endVersion, requestType)
        {
            if (1 == type && YTX_CONFIG._syncMsgPorcessing)
            {
                return
            }
            ;
            if (!!endVersion && endVersion < YTX_CONFIG._maxMsgVersion)
            {
                var type = (!!requestType) ? requestType : -1;
                var sendStr = YTX_CONFIG._protobuf._buildSyncMessage(YTX_CONFIG._msgVersion + 1, endVersion, type, function ()
                {
                });
                if (!!sendStr)
                {
                    YTX_CONFIG._syncMsgPorcessing = true;
                    YTX_CONFIG._sendMsg(sendStr)
                }
                else
                {
                    YTX_CONFIG._syncMsgPorcessing = false
                }
            }
            else if (YTX_CONFIG._msgVersion < YTX_CONFIG._maxMsgVersion)
            {
                var end = YTX_CONFIG._maxMsgVersion;
                for (var i in YTX_CONFIG._receiveMsgBuf)
                {
                    if (i == (YTX_CONFIG._msgVersion + 1))
                    {
                        var msg = YTX_CONFIG._receiveMsgBuf[(YTX_CONFIG._msgVersion + 1)];
                        delete YTX_CONFIG._receiveMsgBuf[(YTX_CONFIG._msgVersion + 1)];
                        YTX_CONFIG._msgVersion = YTX_CONFIG._msgVersion + 1;
                        if (!!msg)
                        {
                            YTX_CONFIG._log(YTX_CONFIG._logLev._INFO, "config message : " + YTX_CONFIG);
                            YTX_CONFIG._noticeApp(msg)
                        }
                    }
                    else
                    {
                        end = i - 1;
                        break
                    }
                }
                if (YTX_CONFIG._msgVersion != YTX_CONFIG._maxMsgVersion)
                {
                    var sendStr = YTX_CONFIG._protobuf._buildSyncMessage(YTX_CONFIG._msgVersion + 1, end, 0, function ()
                    {
                    });
                    if (!!sendStr)
                    {
                        YTX_CONFIG._syncMsgPorcessing = true;
                        YTX_CONFIG._sendMsg(sendStr)
                    }
                    else
                    {
                        YTX_CONFIG._syncMsgPorcessing = false
                    }
                }
                else
                {
                    YTX_CONFIG._syncMsgPorcessing = false
                }
            }
            else
            {
                YTX_CONFIG._syncMsgPorcessing = false
            }
        },
        _onResponse: function (obj)
        {
            YTX_CONFIG._log(YTX_CONFIG._logLev._INFO, "receive msg : " + obj);
            obj = JSON.parse(obj);
            if (!!obj["hb"])
            {
                YTX_CONFIG._heartBeatCallBack(obj["hb"]);
                return
            }
            if (!obj["MsgLite"])
            {
                if (!!obj["Http"])
                {
                    YTX_CONFIG._onHttpResonse(obj)
                }
                return
            }
            obj = obj["MsgLite"];
            if (!!obj["6"] && obj["6"] != YTX_CONFIG._errcode._SUCC)
            {
                YTX_CONFIG._onResponseErr(obj);
                return
            }
            var type = obj["1"];
            if (type == YTX_CONFIG._prototype._callRoute)
            {
                if (obj["6"] == YTX_CONFIG._errcode._SUCC)
                {
                    var data = YTX_CONFIG._clientMap[obj["3"]];
                    if (data && !!data.timeout)
                    {
                        clearTimeout(data.timeout)
                    }
                }
                if (!!obj["2"])
                {
                    if (YTX_CONFIG._routerSwitch && !YTX_CONFIG._voipCallData._msgRouterMap[obj["2"]["CallEventData"]["2"]])
                    {
                        if (obj["2"]["CallEventData"]["1"] == 1 || obj["2"]["CallEventData"]["1"] == 2)
                        {
                            YTX_CONFIG._voipCallData._msgRouterMap[obj["2"]["CallEventData"]["2"]] = obj[9]
                        }
                    }
                    var callEventData = YTX_CONFIG._protobuf._parseCallEventData(obj);
                    YTX_CONFIG._processVoip(callEventData)
                }
                return
            }
            else if (type == YTX_CONFIG._prototype._pushMsg)
            {
                var pushs = obj["2"]["PushMsg"];
                if (pushs["2"] == 6)
                {
                    var url = Base64.decode(YTX_CONFIG._lvs_servers) + pushs["9"];
                    var pushMsg = YTX_CONFIG._protobuf._parsePushMsgResp(obj);
                    YTX_CONFIG._noticeApp(pushMsg)
                }
                ;
                var pushMsg = YTX_CONFIG._protobuf._parsePushMsgResp(obj);
                if (!pushMsg.version)
                {
                    if (pushMsg.msgDomain = "undefined" && !!pushMsg.msgContent)
                    {
                        pushMsg.msgDomain = pushMsg.msgContent;
                        pushMsg.msgContent = null
                    }
                    ;
                    YTX_CONFIG._noticeApp(pushMsg);
                    return
                }
                ;
                if (YTX_CONFIG._msgVersion + 1 == pushMsg.version)
                {
                    YTX_CONFIG._msgVersion += 1;
                    YTX_CONFIG._noticeApp(pushMsg)
                }
                else if (pushMsg.version > YTX_CONFIG._msgVersion)
                {
                    YTX_CONFIG._maxMsgVersion = (YTX_CONFIG._maxMsgVersion < pushMsg.version) ? pushMsg.version : YTX_CONFIG._maxMsgVersion;
                    YTX_CONFIG._receiveMsgBuf[pushMsg.version] = pushMsg;
                    YTX_CONFIG._processSyncMsg(1)
                }
                ;
                if (YTX_CONFIG._msgVersion % 10 == 0)
                {
                    YTX_CONFIG._confirmMsg()
                }
                ;
                return
            }
            else if (type == YTX_CONFIG._prototype._pushMsgNotify)
            {
                var notifyResp = YTX_CONFIG._protobuf._parsePushMsgNotifyResp(obj);
                var msgVersion = notifyResp.version;
                YTX_CONFIG._maxMsgVersion = msgVersion;
                var str = YTX_CONFIG._protobuf._buildSyncMessage(YTX_CONFIG._msgVersion + 1, msgVersion, null, YTX_CONFIG._onSyncMsgRespErr);
                YTX_CONFIG._sendMsg(str);
                return
            }
            else if (type == YTX_CONFIG._prototype._syncMsg)
            {
                var request = YTX_CONFIG._clientMap[obj["3"]];
                if (!request)
                {
                    YTX_CONFIG._log(YTX_CONFIG._logLev._WARN, "receive a unrequest response, clientNo:" + obj["3"]);
                    return
                }
                ;
                console.log("_syncMsg +++++++++++  ");
                var resps = YTX_CONFIG._protobuf._parseSyncMsgResp(obj, request);
                console.log(resps);
                var continuous = true;
                var end = request.endVersion;
                for (var i in resps)
                {
                    var resp = resps[i];
                    if (!resp.version)
                    {
                        continue
                    }
                    if (YTX_CONFIG._msgVersion >= resp.version)
                    {
                        YTX_CONFIG._noticeApp(resp)
                    }
                    else if (YTX_CONFIG._msgVersion + 1 == resp.version)
                    {
                        YTX_CONFIG._msgVersion = (resp.version > YTX_CONFIG._msgVersion) ? resp.version : YTX_CONFIG._msgVersion;
                        if (YTX_CONFIG._msgVersion % 10 == 0)
                        {
                            YTX_CONFIG._confirmMsg()
                        }
                        ;
                        var msgFileUrl = resp.msgFileUrl;
                        YTX_CONFIG._noticeApp(resp);
                        continue
                    }
                    else
                    {
                        if (continuous)
                        {
                            continuous = false;
                            end = resp.version - 1
                        }
                        YTX_CONFIG._receiveMsgBuf[resp.version] = resp
                    }
                }
                ;
                if (!continuous)
                {
                    YTX_CONFIG._syncMsgPorcessing = false;
                    YTX_CONFIG._processSyncMsg(2, end, request.type)
                }
                else
                {
                    YTX_CONFIG._syncMsgPorcessing = false;
                    YTX_CONFIG._processSyncMsg(2)
                }
            }
            else if (type == YTX_CONFIG._prototype._mcmEventData._prototype)
            {
                YTX_CONFIG._protobuf._parseMcmMsg(obj);
                var request = YTX_CONFIG._clientMap[obj["3"]];
                if (!request)
                {
                    return
                }
                try
                {
                    clearTimeout(request.timeout)
                } catch (e)
                {
                    console.log("Cannot read property 'timeout' of undefined")
                }
                if (!!request.callback)
                {
                    if (!!request.msgId)
                    {
                        var resp = {};
                        resp.msgId = request.msgId;
                        request.callback(resp)
                    }
                    else
                    {
                        request.callback()
                    }
                }
                return
            }
            else if (type == YTX_CONFIG._prototype._kickOff)
            {
                var loginRsp = YTX_CONFIG._protobuf._parseKickOffResp(obj);
                if (!!YTX_CONFIG._connectStatListener)
                {
                    YTX_CONFIG._connectStatListener(loginRsp)
                }
                YTX_CONFIG._confirmMsg();
                if (!!YTX_CONFIG._voipCallData._callEventCallId)
                {
                    var releaseCallBuilder = new RL_YTX.ReleaseCallBuilder();
                    releaseCallBuilder.setCallId(YTX_CONFIG._voipCallData._callEventCallId);
                    releaseCallBuilder.setCaller(YTX_CONFIG._voipCallData._caller);
                    releaseCallBuilder.setCalled(YTX_CONFIG._voipCallData._called);
                    RL_YTX.releaseCall(releaseCallBuilder, function (sucObj)
                    {
                    }, function (errObj)
                    {
                    })
                }
                YTX_CONFIG._logout();
                return
            }
            var request = YTX_CONFIG._clientMap[obj["3"]];
            if (!request)
            {
                YTX_CONFIG._log(YTX_CONFIG._logLev._WARN, "receive a unrequest response, clientNo:" + obj["3"]);
                return
            }
            var callback = request.callback;
            try
            {
                clearTimeout(request.timeout)
            } catch (e)
            {
                console.log("Cannot read property 'timeout' of undefined")
            }
            if (!callback)
            {
                return
            }
            if (type == YTX_CONFIG._prototype._login)
            {
                var loginRsp = YTX_CONFIG._protobuf._parseLoginResp(obj);
                if (loginRsp.authState == 1)
                {
                    var loginRsp = YTX_CONFIG._protobuf._parseKickOffResp(obj);
                    YTX_CONFIG._logout();
                    if (!!YTX_CONFIG._connectStatListener)
                    {
                        YTX_CONFIG._connectStatListener(loginRsp)
                    }
                    return
                }
                YTX_CONFIG._loginStatus = 3;
                YTX_CONFIG._reLoginNum = 0;
                YTX_CONFIG._heartBeatErrNum = 0;
                if (!loginRsp.authToken)
                {
                    loginRsp.authToken = obj["8"]
                }
                if (!loginRsp.authToken && !!YTX_CONFIG._token)
                {
                    loginRsp.authToken = YTX_CONFIG._token
                }
                if (YTX_CONFIG._msgVersion == 0)
                {
                    YTX_CONFIG._msgVersion = loginRsp.historyver
                }
                YTX_CONFIG._maxMsgVersion = loginRsp.version;
                if (YTX_CONFIG._msgVersion < YTX_CONFIG._maxMsgVersion)
                {
                    YTX_CONFIG._processSyncMsg(2)
                }
                loginRsp.historyver = loginRsp.version;
                if (YTX_CONFIG._loginType == 2)
                {
                    YTX_CONFIG._sessionId = loginRsp.authToken
                }
                else
                {
                    YTX_CONFIG._token = loginRsp.authToken;
                    YTX_CONFIG._sessionId = loginRsp.authToken
                }
                var transferPolicy = loginRsp.transferPolicy;
                var ipSpeedTestPolicy = loginRsp.ipSpeedTestPolicy;
                delete loginRsp.transferPolicy;
                delete loginRsp.ipSpeedTestPolicy;
                if (YTX_CONFIG._isReconnect)
                {
                    YTX_CONFIG._isReconnect = false;
                    YTX_CONFIG._connectStateChange(3, "reconnect to server suc!")
                }
                if (!!YTX_CONFIG._intervalId)
                {
                    window.clearInterval(YTX_CONFIG._intervalId)
                }
                YTX_CONFIG._intervalId = window.setInterval(YTX_CONFIG._heartBeat, YTX_CONFIG._heartBeatInterval._WIFI * 1000);
                if (!!YTX_CONFIG._failIntervalId)
                {
                    clearInterval(YTX_CONFIG._failIntervalId);
                    YTX_CONFIG._failIntervalId = null
                }
                if (!!callback)
                {
                    callback(loginRsp)
                }
                if (!!transferPolicy)
                {
                    YTX_CONFIG._doTransferPolicy(transferPolicy)
                }
                if (!!ipSpeedTestPolicy)
                {
                    YTX_CONFIG._doIpSpeedTest(ipSpeedTestPolicy)
                }
            }
            else if (type == YTX_CONFIG._prototype._logout)
            {
                YTX_CONFIG._logout();
                callback(YTX_CONFIG._protobuf._parseCodeResp(obj))
            }
            else if (type == YTX_CONFIG._prototype._sendMsg)
            {
                callback(YTX_CONFIG._protobuf._parseSendMsgResp(obj, request))
            }
            else if (type == YTX_CONFIG._prototype._getMyInfo || type == YTX_CONFIG._prototype._setMyInfo)
            {
                callback(YTX_CONFIG._protobuf._parseGetMyInfo(obj))
            }
            else if (type == YTX_CONFIG._prototype._createGroup)
            {
                callback(YTX_CONFIG._protobuf._parseCreateGroupResp(obj))
            }
            else if (type == YTX_CONFIG._prototype._getOwnGroups)
            {
                YTX_CONFIG._protobuf._parseGetGroupListResp(obj, callback, request.onError)
            }
            else if (type == YTX_CONFIG._prototype._queryGroupMembers)
            {
                YTX_CONFIG._protobuf._parseGetGroupMemberListResp(obj, callback, request.onError)
            }
            else if (type == YTX_CONFIG._prototype._getGroupDetail)
            {
                callback(YTX_CONFIG._protobuf._parseGetGroupDetailResp(obj))
            }
            else if (type == YTX_CONFIG._prototype._searchGroups)
            {
                callback(YTX_CONFIG._protobuf._parseSearchGroupsResp(obj))
            }
            else if (type == YTX_CONFIG._prototype._queryGroupMemberCard)
            {
                callback(YTX_CONFIG._protobuf._parseQueryGroupMemberCard(obj))
            }
            else if (type == YTX_CONFIG._prototype._getUserState)
            {
                if (_newUserState)
                {
                    callback(YTX_CONFIG._protobuf._parseGetUserState_multy(obj))
                }
                else
                {
                    callback(YTX_CONFIG._protobuf._parseGetUserState(obj))
                }
            }
            else
            {
                callback(YTX_CONFIG._protobuf._parseCodeResp(obj))
            }
            if (type != YTX_CONFIG._prototype._sendMsg)
            {
                delete YTX_CONFIG._clientMap[obj["3"]]
            }
        },
        _onHttpResonse: function (obj)
        {
            obj = obj["Http"];
            if (!obj)
            {
                return
            }
            if (!!obj["6"] && obj["6"] != YTX_CONFIG._errcode._SUCC)
            {
                YTX_CONFIG._onResponseErr(obj);
                return
            }
            var request = YTX_CONFIG._clientMap[obj["3"]];
            if (!request)
            {
                YTX_CONFIG._log(YTX_CONFIG._logLev._WARN, "receive a unrequest response, clientNo:" + obj["3"]);
                return
            }
            var callback = request.callback;
            try
            {
                clearTimeout(request.timeout)
            } catch (e)
            {
                console.log("Cannot read property 'timeout' of undefined")
            }
            if (!callback)
            {
                return
            }
            var type = obj["1"];
            if (type == YTX_CONFIG._httpType._historyMessage)
            {
                var data = obj;
                var resp = YTX_CONFIG._protobuf._parseGetHistoryMsg(data);
                callback(resp)
            }
            else if (type == YTX_CONFIG._httpType._recentContact)
            {
                var data = obj;
                var resp = YTX_CONFIG._protobuf._parseGetRecentContactList(data);
                callback(resp)
            }
            else
            {
                callback(YTX_CONFIG._protobuf._parseCodeResp(obj))
            }
        },
        _onSyncMsgRespErr: function (obj)
        {
            YTX_CONFIG._log(YTX_CONFIG._logLev._INFO, "syncMsgResp error : " + obj.code)
        },
        _processVoip: function (callEventData)
        {
            if (!YTX_CONFIG._voipCallData._callEventCallId && callEventData.getCallEvent() != 1)
            {
                delete YTX_CONFIG._voipCallData._msgRouterMap[callEventData._callId];
                if (!!YTX_CONFIG._voipCallData._releaseCallbackError && callEventData._callEvent == 10)
                {
                    var obj = [];
                    obj["code"] = callEventData._reason;
                    obj["msg"] = "cancel voip error";
                    return
                }
                ;
                if (!!YTX_CONFIG._voipCallData._releaseCallback)
                {
                    var obj = [];
                    obj["callId"] = callEventData._callId;
                    obj["calltype"] = YTX_CONFIG._voipCallData._voipCallType;
                    YTX_CONFIG._voipCallData._releaseCallback(obj);
                    return
                }
                ;
                return
            }
            if (YTX_CONFIG._voipCallData._callEventCallId != callEventData.getCallId() && callEventData.getCallEvent() != 1)
            {
                return
            }
            if (callEventData.getCallEvent() == 1)
            {
                if (!YTX_CONFIG._voipCallData._callEventCallId)
                {
                    YTX_CONFIG._voipCallData._callEventCallId = callEventData.getCallId();
                    YTX_CONFIG._voipCallData._caller = callEventData.getCaller();
                    YTX_CONFIG._voipCallData._called = callEventData.getCalled();
                    var resp = {};
                    resp.callId = callEventData.getCallId();
                    resp.caller = callEventData.getCaller();
                    resp.called = callEventData.getCalled();
                    resp.userdata = callEventData.getUserData();
                    var sdpStr = callEventData.getStrSDP();
                    YTX_CONFIG._voipCallData._inviteSdp = sdpStr;
                    var type = 0;
                    if (sdpStr.indexOf('m=audio') > -1)
                    {
                        if (sdpStr.indexOf('m=video') > -1)
                        {
                            type = 1
                        }
                    }
                    YTX_CONFIG._voipCallData._voipCallType = type;
                    resp.callType = type;
                    resp.state = 6;
                    resp.code = 200;
                    if (!YTX_CONFIG.util.getUserMedia() || !YTX_CONFIG.util.getPeerConnection())
                    {
                        resp.code = YTX_CONFIG._errcode._NOT_SUPPORT_CALL
                    }
                    YTX_CONFIG._voipListener(resp);
                    var str;
                    if (resp.code == 200)
                    {
                        callEventData.setCallEvent(2);
                        callEventData.setStrSDP();
                        str = YTX_CONFIG._protobuf._buildCallEvent(callEventData, function ()
                        {
                        }, function ()
                        {
                        })
                    }
                    else
                    {
                        callEventData.setCallEvent(10);
                        callEventData.setStrSDP();
                        callEventData.setReason(603);
                        str = YTX_CONFIG._protobuf._buildCallEvent(callEventData, function ()
                        {
                        }, function ()
                        {
                        });
                        YTX_CONFIG._voipCallData._callEventCallId = null
                    }
                    if (!!str)
                    {
                        YTX_CONFIG._sendMsg(str)
                    }
                }
                else if (callEventData.getCallId() == YTX_CONFIG._voipCallData._callEventCallId)
                {
                    return
                }
                else if (callEventData.getCallId() != YTX_CONFIG._voipCallData._callEventCallId)
                {
                    callEventData.setCallEvent(10);
                    callEventData.setReason("486");
                    callEventData.setStrSDP();
                    var str = YTX_CONFIG._protobuf._buildCallEvent(callEventData, function ()
                    {
                    }, function ()
                    {
                    });
                    YTX_CONFIG._sendMsg(str)
                }
            }
            else if (callEventData.getCallEvent() == 2)
            {
                var resp = {};
                resp.callId = callEventData.getCallId();
                resp.caller = callEventData.getCaller();
                resp.called = callEventData.getCalled();
                resp.userdata = callEventData.getUserData();
                resp.state = 1;
                resp.callType = YTX_CONFIG._voipCallData._voipCallType;
                resp.code = 200;
                YTX_CONFIG._voipListener(resp);
                YTX_CONFIG._voipReply200(callEventData)
            }
            else if (callEventData.getCallEvent() == 3)
            {
                if (!!callEventData.getStrSDP())
                {
                    YTX_CONFIG._setTelRemote(callEventData)
                }
                var resp = {};
                resp.callId = callEventData.getCallId();
                resp.caller = callEventData.getCaller();
                resp.called = callEventData.getCalled();
                resp.userdata = callEventData.getUserData();
                resp.state = 1;
                resp.callType = YTX_CONFIG._voipCallData._voipCallType;
                resp.code = 200;
                YTX_CONFIG._voipListener(resp)
            }
            else if (callEventData.getCallEvent() == 4)
            {
                if (!callEventData.getStrSDP())
                {
                    return
                }
                YTX_CONFIG._sendAck(callEventData);
                YTX_CONFIG._voipCallData._connected = true;
                var resp = {};
                resp.callId = callEventData.getCallId();
                resp.caller = callEventData.getCaller();
                resp.called = callEventData.getCalled();
                resp.state = 3;
                resp.callType = YTX_CONFIG._voipCallData._voipCallType;
                resp.code = 200;
                YTX_CONFIG._voipListener(resp)
            }
            else if (callEventData.getCallEvent() == 6)
            {
            }
            else if (callEventData.getCallEvent() == 7 || callEventData.getCallEvent() == 8)
            {
                var resp = {};
                resp.callId = callEventData.getCallId();
                resp.caller = callEventData.getCaller();
                resp.called = callEventData.getCalled();
                resp.userdata = callEventData.getUserData();
                resp.reason = "0";
                resp.state = 5;
                resp.code = 200;
                resp.callType = YTX_CONFIG._voipCallData._voipCallType;
                YTX_CONFIG._voipListener(resp);
                YTX_CONFIG._releaseVoip();
                YTX_CONFIG._voipReply200(callEventData);
                delete YTX_CONFIG._voipCallData._msgRouterMap[callEventData._callId];
                clearInterval(YTX_CONFIG._voipTimer);
                YTX_CONFIG._voipTimestamp = 0
            }
            else if (callEventData.getCallEvent() == 10)
            {
                var resp = {};
                resp.callId = callEventData.getCallId();
                resp.caller = callEventData.getCaller();
                resp.called = callEventData.getCalled();
                if (!!callEventData.getReason())
                {
                    resp.reason = "175" + callEventData.getReason()
                }
                else
                {
                    resp.reason = "0"
                }
                resp.code = 200;
                resp.userdata = callEventData.getUserData();
                resp.callType = YTX_CONFIG._voipCallData._voipCallType;
                resp.state = 4;
                YTX_CONFIG._voipListener(resp);
                YTX_CONFIG._releaseVoip();
                YTX_CONFIG._voipReply200(callEventData);
                delete YTX_CONFIG._voipCallData._msgRouterMap[callEventData._callId]
            }
            else if (callEventData.getCallEvent() == 11 || callEventData.getCallEvent() == 12)
            {
                YTX_CONFIG._voipReply200(callEventData)
            }
            else if (callEventData.getCallEvent() == 15)
            {
                callEventData.setCallEvent(16);
                callEventData.setStrSDP();
                if (YTX_CONFIG._voipCallData._connected)
                {
                    callEventData.setReason(0)
                }
                var str = YTX_CONFIG._protobuf._buildCallEvent(callEventData, function ()
                {
                }, function ()
                {
                });
                YTX_CONFIG._sendMsg(str)
            }
        },
        _voipReply200: function (callEventData)
        {
            callEventData.setCallEvent(4);
            callEventData.setStrSDP();
            var str = YTX_CONFIG._protobuf._buildCallEvent(callEventData, function ()
            {
            }, function ()
            {
            });
            YTX_CONFIG._sendMsg(str)
        },
        _doTransferPolicy: function (transferPolicy)
        {
        },
        _doIpSpeedTest: function (ipSpeedTestPolicy)
        {
            var type = ipSpeedTestPolicy["1"];
            if (type == 2)
            {
                var ipAdds = ipSpeedTestPolicy["2"];
                for (var i in ipAdds)
                {
                    var ipAdd = ipAdds[i];
                    if (ipAdd["3"] != YTX_CONFIG._WS_TYPE)
                    {
                        continue
                    }
                    var count = (!!ipSpeedTestPolicy["3"]) ? ipSpeedTestPolicy["3"] : YTX_CONFIG._ipSpeedTestConfig._count;
                    var interval = (!!ipSpeedTestPolicy["4"]) ? ipSpeedTestPolicy["4"] : YTX_CONFIG._ipSpeedTestConfig._interval;
                    var timeout = (!!ipSpeedTestPolicy["5"]) ? ipSpeedTestPolicy["5"] : YTX_CONFIG._ipSpeedTestConfig._timeout._WIFI;
                    var num = 0, receiveNum = 0;
                    var webSocket = new WebSocket('ws://' + ipAdd["1"] + ":" + ipAdd["2"]);
                    var startTime, endTime, maxDelay = 0, minDelay = 0, totalDelay = 0;
                    var tId = setTimeout(function ()
                    {
                        YTX_CONFIG._log(YTX_CONFIG._logLev._INFO, "ipSpeedTest timeout...");
                        webSocket.close()
                    }, (interval * count + timeout));
                    webSocket.tid = tId;
                    webSocket._ip = ipAdd["1"];
                    webSocket._port = ipAdd["2"];
                    webSocket.num = 0;
                    webSocket.receiveNum = 0;
                    webSocket.onopen = function (event)
                    {
                        var wb = this;
                        YTX_CONFIG._log(YTX_CONFIG._logLev._INFO, "start ipSpeedTest...");
                        var intervalId = setInterval(function ()
                        {
                            var tstamp = new Date().getTime();
                            if (wb.num == 0)
                            {
                                wb.startTime = tstamp
                            }
                            var str = '{"hb":' + (tstamp) + '}';
                            wb.send(str);
                            wb.num++;
                            if (wb.num >= count)
                            {
                                clearInterval(intervalId)
                            }
                        }, interval)
                    };
                    webSocket.onmessage = function (event)
                    {
                        var data = event.data;
                        data = JSON.parse(data);
                        this.endTime = new Date().getTime();
                        var stime = data["hb"];
                        var delay = this.endTime - stime;
                        if (!this.totalDelay)
                        {
                            this.totalDelay = 0
                        }
                        this.totalDelay += delay;
                        if (!this.maxDelay)
                        {
                            this.maxDelay = delay
                        }
                        else
                        {
                            if (this.maxDelay < delay)
                            {
                                this.maxDelay = delay
                            }
                        }
                        if (!this.minDelay)
                        {
                            this.minDelay = delay
                        }
                        else
                        {
                            if (this.minDelay > delay)
                            {
                                this.minDelay = delay
                            }
                        }
                        this.receiveNum++;
                        if (this.receiveNum == count)
                        {
                            if (!!this.tid)
                            {
                                clearTimeout(this.tid)
                            }
                            this.close()
                        }
                    };
                    webSocket.onclose = function (event)
                    {
                        YTX_CONFIG._log(YTX_CONFIG._logLev._INFO, "ipSpeedTest complete...");
                        var netWork = YTX_CONFIG._getNetWork();
                        var lost, averageDelay, costtime;
                        if (this.receiveNum > 0)
                        {
                            lost = (count - this.receiveNum) / count * 100;
                            averageDelay = this.totalDelay / this.receiveNum
                        }
                        else
                        {
                            lost = 100
                        }
                        var jsonStr = '{\"IpSpeedResult\":{\"1\":' + netWork + ',' + '\"3\":\"' + this._ip + '\",' + '\"4\":' + this._port + ',' + '\"5\":' + lost;
                        if (averageDelay > 0)
                        {
                            jsonStr += ',\"6\":' + averageDelay
                        }
                        if (this.minDelay > 0)
                        {
                            jsonStr += ',\"7\":' + this.minDelay
                        }
                        if (this.maxDelay > 0)
                        {
                            jsonStr += ',\"8\":' + this.maxDelay
                        }
                        if (!!ipSpeedTestPolicy["7"])
                        {
                            jsonStr += ',\"11\":\"' + ipSpeedTestPolicy["7"] + '\"'
                        }
                        jsonStr += '}}';
                        var str = '{\"MsgLite\":{\"1\":' + YTX_CONFIG._prototype._ipSpeedTest + ',\"2\":' + jsonStr + '}}';
                        if (YTX_CONFIG._loginStatus == 3)
                        {
                            YTX_CONFIG._sendMsg(str)
                        }
                    }
                }
            }
            else if (type == 1)
            {
            }
        },
        _getNetWork: function ()
        {
            return 1
        },
        _onResponseErr: function (obj)
        {
            var request = YTX_CONFIG._clientMap[obj["3"]];
            if (YTX_CONFIG._loginStatus == 2)
            {
                YTX_CONFIG._loginStatus = 1
            }
            if (!!request)
            {
                try
                {
                    clearTimeout(request.timeout)
                } catch (e)
                {
                    console.log("Cannot read property 'timeout' of undefined")
                }
            }
            if (obj["1"] == YTX_CONFIG._prototype._getMyInfo && obj["6"] == 520015)
            {
                var callback = request.callback;
                var resp = {};
                resp.version = 1;
                resp.nickName = YTX_CONFIG._userName;
                resp.sex = 0;
                resp.birth = '1970-01-01';
                callback(resp)
            }
            else if ((obj["6"] >= 520001 && obj["6"] <= 520010) || (obj["6"] >= 520018 && obj["6"] <= 520019) || (obj["6"] >= 520021 && obj["6"] <= 520021) || (obj["6"] >= 520023 && obj["6"] <= 520023) || obj["6"] == 529998)
            {
                var onError = request.onError;
                onError(YTX_CONFIG._protobuf._parseCodeResp(obj));
                return
            }
            else if ((obj["6"] >= 520000 && obj["6"] <= 529999) || (obj["6"] >= 550000 && obj["6"] <= 559999) || obj["6"] == 219000)
            {
                YTX_CONFIG._isReconnect = true;
                YTX_CONFIG._reLoginNum++;
                if (YTX_CONFIG._reLoginNum > 10)
                {
                    setTimeout(function ()
                    {
                        YTX_CONFIG._reLoginNum = 1;
                        YTX_CONFIG._loginStatus = 1;
                        if (!!YTX_CONFIG._socket)
                        {
                            YTX_CONFIG._socket.onclose = function ()
                            {
                            };
                            YTX_CONFIG._socket.close();
                            YTX_CONFIG._socket = null
                        }
                        var onError = function ()
                        {
                        };
                        var callback = function ()
                        {
                        };
                        if (!!request)
                        {
                            onError = request.onError;
                            callback = request.callback
                        }
                        onError(YTX_CONFIG._protobuf._parseCodeResp(obj));
                        YTX_CONFIG._connectStateChange(5, "connect fail,please relogin");
                        return
                    }, 10000)
                }
                else
                {
                    YTX_CONFIG._loginStatus = 1;
                    if (!!YTX_CONFIG._socket)
                    {
                        YTX_CONFIG._socket.onclose = function ()
                        {
                        };
                        YTX_CONFIG._socket.close();
                        YTX_CONFIG._socket = null
                    }
                    var onError = function ()
                    {
                    };
                    var callback = function ()
                    {
                    };
                    if (!!request)
                    {
                        onError = request.onError;
                        callback = request.callback
                    }
                    onError(YTX_CONFIG._protobuf._parseCodeResp(obj));
                    YTX_CONFIG._connectStateChange(5, "connect fail,please relogin");
                    return
                }
            }
            var onError = request.onError;
            if (obj["1"] == YTX_CONFIG._prototype._login)
            {
                YTX_CONFIG._loginStatus = 1
            }
            if (obj["1"] == YTX_CONFIG._prototype._sendMsg || obj["1"] == YTX_CONFIG._prototype._mcmEventData._prototype)
            {
                onError(YTX_CONFIG._protobuf._parseSendMsgRespErr(obj, request));
                return
            }
            delete YTX_CONFIG._clientMap[obj["3"]];
            var callback = request.callback;
            if (obj["6"] == 580005)
            {
                if (!request.repeat || request.repeat < 3)
                {
                    if (!!request.repeat)
                    {
                        request.repeat += 1
                    }
                    else
                    {
                        request.repeat = 2
                    }
                    var sendStr = YTX_CONFIG._protobuf._buildSyncMessage(YTX_CONFIG._msgVersion + 1, request.endVersion, request.type, function ()
                    {
                    }, request.repeat);
                    if (!!sendStr)
                    {
                        YTX_CONFIG._sendMsg(sendStr)
                    }
                }
                else
                {
                    if ((request.endVersion - YTX_CONFIG._msgVersion) > 10)
                    {
                        YTX_CONFIG._msgVersion = YTX_CONFIG._msgVersion + 10
                    }
                    else
                    {
                        YTX_CONFIG._msgVersion = request.endVersion
                    }
                    YTX_CONFIG._processSyncMsg()
                }
            }
            else
            {
                onError(YTX_CONFIG._protobuf._parseCodeResp(obj))
            }
        },
        _getServerIp: function (type, callback, onError, sig, timestamp, reset)
        {
            if (!YTX_CONFIG.getServer)
            {
                YTX_CONFIG._initScoket(type, callback, onError, sig, timestamp, reset);
                return
            }
            var appid = YTX_CONFIG._appid;
            var apptoken = YTX_CONFIG._token;
            var accunt = '';
            var sigs = '';
            var w = '';
            if (type == 1)
            {
                sigs = sig;
                accunt = appid;
                w = 'Application/'
            }
            else
            {
                sigs = hex_md5(appid + YTX_CONFIG._userName + timestamp + YTX_CONFIG._userPwd);
                accunt = window.encodeURIComponent(appid + '#' + YTX_CONFIG._userName);
                w = 'User/'
            }
            var datas = {
                "sig": sigs,
                "userName": YTX_CONFIG._userName,
                "authorization": timestamp,
                "version": YTX_CONFIG._version,
                "type": type.toString()
            };
            $.ajax({
                type: "POST",
                url: Base64.decode(YTX_CONFIG._app_server) + w + accunt + "/GetServerBalance",
                dataType: 'jsonp',
                jsonp: 'cb',
                data: datas,
                async: false,
                success: function (e)
                {
                    var lvs = 'https://' + e["LVS"][0].host + ":" + e["LVS"][0].port;
                    var fileurl = 'wss://' + e["webSocketServer"][0].host + ":" + e["webSocketServer"][0].port + "/ws";
                    var server = 'wss://' + e["webSocketServer"][0].host + ":" + e["webSocketServer"][0].port + "/ws";
                    YTX_CONFIG._lvs_servers = [Base64.encode(lvs)];
                    YTX_CONFIG._file_server_url = Base64.encode(fileurl);
                    YTX_CONFIG._server_ip = [Base64.encode(server)];
                    YTX_CONFIG._initScoket(type, callback, onError, sig, timestamp, reset)
                },
                error: function (e)
                {
                    alert('get server failed, please check the parameter');
                    console.log(e)
                }
            })
        },
        _initScoket: function (type, callback, onError, sig, timestamp, reset)
        {
            /*
            window.onbeforeunload = function (event)
            {
                YTX_CONFIG._confirmMsg();
                var releaseCallBuilder = new RL_YTX.ReleaseCallBuilder();
                releaseCallBuilder.setCallId(YTX_CONFIG._voipCallData._callEventCallId);
                releaseCallBuilder.setCaller(YTX_CONFIG._voipCallData._caller);
                releaseCallBuilder.setCalled(YTX_CONFIG._voipCallData._called);
                RL_YTX.releaseCall(releaseCallBuilder, function (sucObj)
                {
                }, function (errObj)
                {
                });
                if (!!YTX_CONFIG._beforeUnLoad)
                {
                    for (i in YTX_CONFIG._beforeUnLoad)
                    {
                        if (typeof YTX_CONFIG._beforeUnLoad[i] == "function")
                        {
                            YTX_CONFIG._beforeUnLoad[i]()
                        }
                        else
                        {
                            continue
                        }
                    }
                }

                return true;
                //return confirm("确定离开此页面吗？")
            };
            */
            if (reset)
            {
                if (!!YTX_CONFIG._socket)
                {
                    YTX_CONFIG._socket.onclose = function ()
                    {
                    };
                    YTX_CONFIG._socket.close();
                    YTX_CONFIG._socket = null
                }
                YTX_CONFIG._isConnect = false;
                YTX_CONFIG._isConnecting = false
            }
            if (!YTX_CONFIG._isConnect)
            {
                if (!YTX_CONFIG._isConnecting)
                {
                    var serverip = Base64.decode(YTX_CONFIG._server_ip[0]);
                    YTX_CONFIG._socket = new WebSocket(serverip);
                    YTX_CONFIG._isConnecting = true;
                    var tId = setTimeout(function ()
                    {
                        if (YTX_CONFIG._isConnecting)
                        {
                            YTX_CONFIG._isConnecting = false;
                            var resp = {};
                            resp.code = YTX_CONFIG._errcode._NETWORK_TIME_OUT;
                            resp.msg = '连接服务器超时，请刷新重试.';
                            onError(resp);
                            return
                        }
                    }, YTX_CONFIG._timeOutSecond * 1000);
                    var sessionId = YTX_CONFIG._currentSession;
                    YTX_CONFIG._socket.onopen = function (event)
                    {
                        if (!!tId)
                        {
                            clearTimeout(tId)
                        }
                        YTX_CONFIG._log(YTX_CONFIG._logLev._INFO, "Client connect to Server ");
                        YTX_CONFIG._isConnect = true;
                        YTX_CONFIG._isConnecting = false;
                        if (!YTX_CONFIG._imei)
                        {
                            YTX_CONFIG._protobuf._generateImei()
                        }
                        YTX_CONFIG._loginType = type;
                        var sendStr = YTX_CONFIG._protobuf._buildLogin(type, callback, onError, sig, timestamp);
                        if (!!sendStr)
                        {
                            YTX_CONFIG._loginStatus = 2;
                            YTX_CONFIG._sendMsg(sendStr)
                        }
                    };
                    YTX_CONFIG._socket.onmessage = function (event)
                    {
                        if (sessionId != YTX_CONFIG._currentSession)
                        {
                            return
                        }
                        var timeStamp = YTX_CONFIG._getTimeStamp();
                        YTX_CONFIG._log(YTX_CONFIG._logLev._INFO, timeStamp + ' Client received a message', event);
                        YTX_CONFIG._onResponse(event.data)
                    };
                    YTX_CONFIG._socket.onclose = function (event)
                    {
                        var releaseCallBuilder = new RL_YTX.ReleaseCallBuilder();
                        releaseCallBuilder.setCallId(YTX_CONFIG._voipCallData._callEventCallId);
                        releaseCallBuilder.setCaller(YTX_CONFIG._voipCallData._caller);
                        releaseCallBuilder.setCalled(YTX_CONFIG._voipCallData._called);
                        RL_YTX.releaseCall(releaseCallBuilder, function (sucObj)
                        {
                        }, function (errObj)
                        {
                        });
                        if (!!tId)
                        {
                            clearTimeout(tId)
                        }
                        if (sessionId != YTX_CONFIG._currentSession)
                        {
                            return
                        }
                        YTX_CONFIG._log(YTX_CONFIG._logLev._INFO, 'Client notified socket has closed', event);
                        if (YTX_CONFIG._loginStatus == 3)
                        {
                            YTX_CONFIG._isConnect = false;
                            YTX_CONFIG._isConnecting = false;
                            YTX_CONFIG._loginStatus = 1;
                            YTX_CONFIG._connectStateChange(1, "connect closeed");
                            YTX_CONFIG._reconnect(function ()
                            {
                            });
                            if (!!YTX_CONFIG._intervalId)
                            {
                                window.clearInterval(YTX_CONFIG._intervalId)
                            }
                            YTX_CONFIG._intervalId = window.setInterval(YTX_CONFIG._heartBeat, YTX_CONFIG._heartBeatInterval._RECONNECT * 1000)
                        }
                        else if (YTX_CONFIG._isConnecting)
                        {
                            YTX_CONFIG._isConnecting = false;
                            var resp = {};
                            resp.code = YTX_CONFIG._errcode._NETWORK_ERR;
                            resp.msg = 'connecting to websocket, please wait.';
                            onError(resp);
                            return
                        }
                        YTX_CONFIG._isConnecting = false
                    }
                }
                else
                {
                    YTX_CONFIG._log(YTX_CONFIG._logLev._INFO, 'Client is connecting to server, please wait')
                }
            }
            else
            {
                if (YTX_CONFIG._loginStatus == 1)
                {
                    var sendStr = YTX_CONFIG._protobuf._buildLogin(type, callback, onError, sig, timestamp);
                    if (!!sendStr)
                    {
                        YTX_CONFIG._loginStatus = 2;
                        YTX_CONFIG._sendMsg(sendStr)
                    }
                }
                else if (YTX_CONFIG._loginStatus == 2)
                {
                    YTX_CONFIG._log(YTX_CONFIG._logLev._INFO, 'user is logining, please wait..')
                }
                else
                {
                    YTX_CONFIG._log(YTX_CONFIG._logLev._INFO, 'user was login')
                }
            }
        },
        _checkOnline: function (onErr, msgId, msgClientNo)
        {
            var resp = {};
            if (!YTX_CONFIG._userName)
            {
                resp.code = YTX_CONFIG._errcode._NO_LOGIN;
                if (!!msgId)
                {
                    resp.msgId = msgId
                }
                if (!!msgClientNo)
                {
                    resp.msgClientNo = msgClientNo
                }
                resp.msg = 'user not login';
                onErr(resp);
                return false
            }
            if (YTX_CONFIG._loginStatus != 3)
            {
                YTX_CONFIG._log(YTX_CONFIG._logLev._WARN, "no user login");
                if (YTX_CONFIG._isConnect)
                {
                    resp.code = YTX_CONFIG._errcode._NO_LOGIN
                }
                else
                {
                    resp.code = YTX_CONFIG._errcode._NETWORK_ERR
                }
                if (!!msgId)
                {
                    resp.msgId = msgId
                }
                if (!!msgClientNo)
                {
                    resp.msgClientNo = msgClientNo
                }
                resp.msg = 'user not login';
                onErr(resp);
                return false
            }
            return true
        },
        _generateFullMsgId: function (msgId)
        {
            return YTX_CONFIG._token + '|' + msgId
        },
        _protobuf: {
            _buildLogout: function (callback, onError)
            {
                if (!YTX_CONFIG._checkOnline(function ()
                    {
                    }, null))
                {
                    YTX_CONFIG._logout();
                    return null
                }
                if (!YTX_CONFIG._imei)
                {
                    YTX_CONFIG._protobuf._generateImei()
                }
                var logOutStr = '{\"Logout\":{\"1\":\"' + YTX_CONFIG._imei + '\"}}';
                return '{\"MsgLite\":{\"1\":' + YTX_CONFIG._prototype._logout + ',\"2\":' + logOutStr + ',\"3\":' + (YTX_CONFIG._generateClientNo(callback, function ()
                    {
                    })) + '}}'
            },
            _buildLogin: function (type, callback, onError, sig, timestamp)
            {
                var resp = {};
                if (type != 1 && type != 2 && type != 3)
                {
                    return null
                }
                if (type != 2)
                {
                    if (!YTX_CONFIG._userName)
                    {
                        resp.code = YTX_CONFIG._errcode._LOGIN_NO_USERNAME;
                        resp.msg = 'param userName is empty';
                        onError(resp);
                        return null
                    }
                }
                if (type == 3 && !YTX_CONFIG._userPwd)
                {
                    resp.code = YTX_CONFIG._errcode._LOGIN_NO_PWD;
                    resp.msg = 'param userPwd is empty';
                    onError(resp);
                    return null
                }
                if (!YTX_CONFIG._imei)
                {
                    YTX_CONFIG._protobuf._generateImei()
                }
                if (!YTX_CONFIG._userPwd)
                {
                    YTX_CONFIG._userPwd = ''
                }
                if (!sig)
                {
                    sig = ''
                }
                if (!timestamp)
                {
                    timestamp = ''
                }
                var loginJsonStr;
                if (type != 2)
                {
                    loginJsonStr = '{\"UserAuth\":{\"1\":' + type + ',' + '\"2\":\"' + YTX_CONFIG._appid + '\",' + '\"3\":\"' + YTX_CONFIG._userName + '\",' + '\"4\":\"' + timestamp + '\",' + '\"5\":' + YTX_CONFIG._deviceType + ',\"6\":\"' + sig + '\",' + '\"7\":\"' + YTX_CONFIG._version + '\",' + '\"8\":\"' + YTX_CONFIG._imei + '\",\"9\":' + YTX_CONFIG._loginMode + ',' + '\"10\":' + YTX_CONFIG._network + ',\"11\":\"' + YTX_CONFIG._userPwd + '\"' + '}}';
                    return '{\"MsgLite\":{\"1\":' + YTX_CONFIG._prototype._login + ',\"2\":' + loginJsonStr + ',\"3\":' + (YTX_CONFIG._generateClientNo(callback, onError)) + '}}'
                }
                else
                {
                    loginJsonStr = '{\"UserAuth\":{\"1\":2,' + '\"8\":\"' + YTX_CONFIG._imei + '\",\"10\":' + YTX_CONFIG._network + '}}';
                    return '{\"MsgLite\":{\"1\":' + YTX_CONFIG._prototype._login + ',\"2\":' + loginJsonStr + ',\"3\":' + (YTX_CONFIG._generateClientNo(callback, onError)) + ',\"8\":\"' + YTX_CONFIG._token + '\"}}'
                }
            },
            _generateImei: function ()
            {
                YTX_CONFIG._imei = hex_md5(YTX_CONFIG._appid + YTX_CONFIG._userName + YTX_CONFIG._sdkName)
            },
            _buildHeartBeat: function ()
            {
                var id = setTimeout(YTX_CONFIG._heartBeatCallBackErr(++YTX_CONFIG._heartBeatErrNum), YTX_CONFIG._heartBeatTimeOut * 1000);
                return '{"hb":' + id + '}'
            },
            _buildSendTextMsg: function (msgType, content, receiver, msgId, msgDomain, callback, onError, orignMsgId, atAccounts)
            {
                var allMsgId = YTX_CONFIG._generateFullMsgId(msgId);
                if (!YTX_CONFIG._checkOnline(onError, orignMsgId, allMsgId))
                {
                    YTX_CONFIG._ClientNo++;
                    return null
                }
                if (!receiver)
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msgId = orignMsgId;
                    resp.msgClientNo = allMsgId;
                    resp.msg = 'param receiver is empty';
                    onError(resp);
                    return
                }
                if (!content && msgType != 12)
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msgId = orignMsgId;
                    resp.msgClientNo = allMsgId;
                    resp.msg = 'param content is empty';
                    onError(resp);
                    return
                }
                if (content.length > YTX_CONFIG._maxMsgLen)
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._TEXT_TOO_LONG;
                    resp.msgId = orignMsgId;
                    resp.msgClientNo = allMsgId;
                    resp.msg = 'param content over ' + YTX_CONFIG._maxMsgLen + ' character, too large.';
                    onError(resp);
                    return
                }
                var compress = false;
                var len = 0;
                if (content.length > 200)
                {
                }
                content = Base64.encode(content);
                var sendJsonStr = new Object();
                if (!!atAccounts)
                {
                    if (atAccounts instanceof Array && atAccounts.length > 0)
                    {
                        sendJsonStr['1'] = msgType
                    }
                    else
                    {
                        var resp = {};
                        resp.code = 170012;
                        resp.msg = "param atAccounts isn't an Array or is empty";
                        onError(resp);
                        return
                    }
                }
                else
                {
                    sendJsonStr['1'] = msgType
                }
                sendJsonStr['2'] = msgId + '';
                sendJsonStr['3'] = content;
                sendJsonStr['4'] = YTX_CONFIG._userName;
                sendJsonStr['5'] = receiver;
                if (!!msgDomain || 0 == msgDomain)
                {
                    sendJsonStr['6'] = msgDomain
                }
                if (compress)
                {
                    sendJsonStr['8'] = len
                }
                if (!!atAccounts && atAccounts.length > 0)
                {
                    var atStr = new Object();
                    console.log("sendMsg:extopts=" + atAccounts.join(","));
                    atStr["at"] = atAccounts;
                    sendJsonStr['11'] = Base64.encode(JSON.stringify(atStr))
                }
                sendJsonStr = JSON.stringify(sendJsonStr);
                var sendProto = '{\"SendMsg\":' + sendJsonStr + '}';
                var clientNo = YTX_CONFIG._generateClientNo(callback, onError, allMsgId, '', '', '', orignMsgId, true);
                return '{\"MsgLite\":{\"1\":' + YTX_CONFIG._prototype._sendMsg + ',\"2\":' + sendProto + ',\"3\":' + clientNo + '}}'
            },
            _buildSendFileMsgStart: function (file, content, receiver, msgType, msgId, msgDomain, type, onError, fileName, msgClientNo)
            {
                if (!YTX_CONFIG._checkOnline(onError, msgId, msgClientNo))
                {
                    return null
                }
                var name = null;
                if (file instanceof File)
                {
                    name = file.name
                }
                else if (!!fileName)
                {
                    name = fileName
                }
                else if (!!file.fileName)
                {
                    name = file.fileName
                }
                else
                {
                    name = msgId
                }
                var sig = YTX_CONFIG._fileSig.toUpperCase();
                var sendJsonStr = new Object();
                sendJsonStr['1'] = YTX_CONFIG._appid;
                sendJsonStr['2'] = msgType + '';
                sendJsonStr['3'] = ((!!content) ? content : '');
                sendJsonStr['4'] = ((!!msgDomain) ? msgDomain : '');
                sendJsonStr['5'] = YTX_CONFIG._userName;
                sendJsonStr['6'] = receiver;
                sendJsonStr['7'] = name;
                sendJsonStr['8'] = YTX_CONFIG._imei;
                sendJsonStr['9'] = YTX_CONFIG._token + new Date().getTime();
                sendJsonStr['10'] = sig;
                sendJsonStr['11'] = type + '';
                sendJsonStr['12'] = ((!!file.size) ? file.size : '');
                sendJsonStr['13'] = msgClientNo;
                sendJsonStr = JSON.stringify(sendJsonStr);
                return '{\"start\":' + sendJsonStr + '}'
            },
            _buildSendFileMsgEnd: function (callback, onError, msgId, orignMsgId)
            {
                var jsonStr = '{\"1\":' + YTX_CONFIG._generateClientNo(callback, onError, msgId, '', '', '', orignMsgId, true) + '}';
                return '{\"end\":' + jsonStr + '}'
            },
            _buildMCM_UserEvt_StartAsk: function (osUnityAccount, agentId, userData, addrJson, callback, onError)
            {
                if (!YTX_CONFIG._checkOnline(onError))
                {
                    return null
                }
                if (!osUnityAccount)
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = 'param osUnityAccount is empty';
                    onError(resp);
                    return
                }
                var jsonStr = new Object();
                jsonStr['1'] = YTX_CONFIG._prototype._mcmEventData._mcmEventDef._UserEvt_StartAsk;
                jsonStr['5'] = osUnityAccount;
                jsonStr['10'] = agentId;
                jsonStr['19'] = JSON.stringify(addrJson);
                jsonStr['20'] = 0;
                jsonStr = JSON.stringify(jsonStr);
                jsonStr = '{\"MCMData\":' + jsonStr + '}';
                return '{\"MsgLite\":{\"1\":' + YTX_CONFIG._prototype._mcmEventData._prototype + ',\"2\":' + jsonStr + ',\"3\":' + (YTX_CONFIG._generateClientNo(callback, onError)) + '}}'
            },
            _buildMCM_UserEvt_EndAsk: function (osUnityAccount, userData, callback, onError)
            {
                if (!YTX_CONFIG._checkOnline(onError))
                {
                    return null
                }
                if (!osUnityAccount)
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = 'param osUnityAccount is empty';
                    onError(resp);
                    return
                }
                var jsonStr = new Object();
                jsonStr['1'] = YTX_CONFIG._prototype._mcmEventData._mcmEventDef._UserEvt_EndAsk;
                jsonStr['5'] = osUnityAccount;
                jsonStr = JSON.stringify(jsonStr);
                jsonStr = '{\"MCMData\":' + jsonStr + '}';
                return '{\"MsgLite\":{\"1\":' + YTX_CONFIG._prototype._mcmEventData._prototype + ',\"2\":' + jsonStr + ',\"3\":' + (YTX_CONFIG._generateClientNo(callback, onError)) + '}}'
            },
            _buildMCM_UserEvt_SendMSG: function (osUnityAccount, content, userData, type, msgId, callback, onError, orignMsgId)
            {
                var allMsgId = YTX_CONFIG._token + '|' + msgId;
                if (!YTX_CONFIG._checkOnline(onError))
                {
                    return null
                }
                if (!content)
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msgId = orignMsgId;
                    resp.msgClientNo = allMsgId;
                    resp.msg = 'param content is empty.';
                    onError(resp);
                    return
                }
                if (!osUnityAccount)
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = 'param osUnityAccount is empty';
                    onError(resp);
                    return
                }
                var jsonStr = new Object();
                jsonStr['1'] = YTX_CONFIG._prototype._mcmEventData._mcmEventDef._UserEvt_SendMSG;
                jsonStr['5'] = osUnityAccount;
                var msgData = new Object();
                msgData['1'] = type;
                msgData['2'] = content;
                var msgDataArray = [];
                msgDataArray[0] = msgData;
                jsonStr['6'] = msgDataArray;
                jsonStr = JSON.stringify(jsonStr);
                jsonStr = '{\"MCMData\":' + jsonStr + '}';
                return '{\"MsgLite\":{\"1\":' + YTX_CONFIG._prototype._mcmEventData._prototype + ',\"2\":' + jsonStr + ',\"3\":' + (YTX_CONFIG._generateClientNo(callback, onError, allMsgId, '', '', '', orignMsgId)) + '}}'
            },
            _buildMCM_AgentEvt_SendMCM: function (userAccount, content, userData, type, msgId, callback, onError, orignMsgId, chanType, mailTitle)
            {
                var allMsgId = YTX_CONFIG._token + '|' + msgId;
                if (!YTX_CONFIG._checkOnline(onError))
                {
                    return null
                }
                if (!content)
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msgId = orignMsgId;
                    resp.msgClientNo = allMsgId;
                    resp.msg = 'param content is empty.';
                    onError(resp);
                    return
                }
                if (!userAccount)
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = 'param userAccount is empty';
                    onError(resp);
                    return
                }
                var jsonStr = new Object();
                jsonStr['1'] = YTX_CONFIG._prototype._mcmEventData._mcmEventDef._AgentEvt_SendMCM;
                jsonStr['4'] = userAccount;
                jsonStr['8'] = chanType;
                var msgData = new Object();
                msgData['1'] = type;
                msgData['2'] = content;
                if (chanType == YTX_CONFIG._prototype._mcmEventData._mcmChannel._MCType_mail)
                {
                    msgData['5'] = mailTitle
                }
                var msgDataArray = [];
                msgDataArray[0] = msgData;
                jsonStr['6'] = msgDataArray;
                jsonStr = JSON.stringify(jsonStr);
                jsonStr = '{\"MCMData\":' + jsonStr + '}';
                return '{\"MsgLite\":{\"1\":' + YTX_CONFIG._prototype._mcmEventData._prototype + ',\"2\":' + jsonStr + ',\"3\":' + (YTX_CONFIG._generateClientNo(callback, onError, allMsgId, '', '', '', orignMsgId)) + '}}'
            },
            _buildMCM_AgentEvt_StartSerWithUser: function (userAccount, MCMDataBuilder, agentId, callback, onError)
            {
                if (!YTX_CONFIG._checkOnline(onError))
                {
                    return null
                }
                if (!userAccount)
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = 'param userAccount is empty';
                    onError(resp);
                    return
                }
                var jsonStr = new Object();
                jsonStr['1'] = YTX_CONFIG._prototype._mcmEventData._mcmEventDef._AgentEvt_StartSerWithUser;
                jsonStr['4'] = userAccount;
                jsonStr['10'] = agentId;
                if (!!MCMDataBuilder && !!MCMDataBuilder.getCcpCustomData())
                {
                    jsonStr['17'] = MCMDataBuilder.getCcpCustomData()
                }
                jsonStr = JSON.stringify(jsonStr);
                jsonStr = '{\"MCMData\":' + jsonStr + '}';
                return '{\"MsgLite\":{\"1\":' + YTX_CONFIG._prototype._mcmEventData._prototype + ',\"2\":' + jsonStr + ',\"3\":' + (YTX_CONFIG._generateClientNo(callback, onError)) + '}}'
            },
            _buildMCM_AgentEvt_StopSerWithUser: function (userAccount, callback, onError)
            {
                if (!YTX_CONFIG._checkOnline(onError))
                {
                    return null
                }
                if (!userAccount)
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = 'param userAccount is empty';
                    onError(resp);
                    return
                }
                ;
                var jsonStr = new Object();
                jsonStr['1'] = YTX_CONFIG._prototype._mcmEventData._mcmEventDef._AgentEvt_StopSerWithUser;
                jsonStr['4'] = userAccount;
                jsonStr = JSON.stringify(jsonStr);
                jsonStr = '{\"MCMData\":' + jsonStr + '}';
                return '{\"MsgLite\":{\"1\":' + YTX_CONFIG._prototype._mcmEventData._prototype + ',\"2\":' + jsonStr + ',\"3\":' + (YTX_CONFIG._generateClientNo(callback, onError)) + '}}'
            },
            _buildMCM_AgentEvt_KFOnWork: function (serverCap, MCMAgentInfoBuilder, callback, onError)
            {
                if (!YTX_CONFIG._checkOnline(onError))
                {
                    return null
                }
                var errorStr = undefined;
                if ((!!MCMAgentInfoBuilder.getImState()) && isNaN(MCMAgentInfoBuilder.getImState()))
                {
                    errorStr = 'ImState'
                }
                else if ((!!MCMAgentInfoBuilder.getTelState()) && isNaN(MCMAgentInfoBuilder.getTelState()))
                {
                    errorStr = 'TelState'
                }
                else if ((!!MCMAgentInfoBuilder.getDelayCall()) && isNaN(MCMAgentInfoBuilder.getDelayCall()))
                {
                    errorStr = 'DelayCall'
                }
                else if ((!!MCMAgentInfoBuilder.getAnswerTimeout()) && isNaN(MCMAgentInfoBuilder.getAnswerTimeout()))
                {
                    errorStr = 'AnswerTimeout'
                }
                else if ((!!MCMAgentInfoBuilder.getMaxImUser()) && isNaN(MCMAgentInfoBuilder.getMaxImUser()))
                {
                    errorStr = 'MaxImUser'
                }
                else if ((!!MCMAgentInfoBuilder.getAgentServerMode()) && isNaN(MCMAgentInfoBuilder.getAgentServerMode()))
                {
                    errorStr = 'AgentServerMode'
                }
                else if ((!!serverCap) && isNaN(serverCap))
                {
                    errorStr = 'serverCap'
                }
                if (!!errorStr)
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = 'param ' + errorStr + ' is not a number';
                    onError(resp);
                    return
                }
                var jsonStr = new Object();
                jsonStr['1'] = YTX_CONFIG._prototype._mcmEventData._mcmEventDef._AgentEvt_KFOnWork;
                jsonStr['20'] = 0;
                jsonStr['22'] = (!!serverCap) ? serverCap : 5;
                jsonStr['10'] = MCMAgentInfoBuilder.getAgentId();
                var jsonStr13 = new Object();
                jsonStr13['1'] = MCMAgentInfoBuilder.getAgentId();
                if (!!MCMAgentInfoBuilder.getImState())
                {
                    jsonStr13['2'] = MCMAgentInfoBuilder.getImState();
                }
                if (!!MCMAgentInfoBuilder.getTelState())
                {
                    jsonStr13['3'] = MCMAgentInfoBuilder.getTelState();
                }
                if (!!MCMAgentInfoBuilder.getNumber())
                {
                    jsonStr13['4'] = MCMAgentInfoBuilder.getNumber();
                }
                if (!!MCMAgentInfoBuilder.getPushVoipacc())
                {
                    jsonStr13['5'] = MCMAgentInfoBuilder.getPushVoipacc();
                }
                if (!!MCMAgentInfoBuilder.getQueueType())
                {
                    jsonStr13['6'] = MCMAgentInfoBuilder.getQueueType();
                }
                if (!!MCMAgentInfoBuilder.getUserInfoCallbackurl())
                {
                    jsonStr13['7'] = MCMAgentInfoBuilder.getUserInfoCallbackurl();
                }
                if (!!MCMAgentInfoBuilder.getDelayCall())
                {
                    jsonStr13['8'] = MCMAgentInfoBuilder.getDelayCall();
                }
                if (!!MCMAgentInfoBuilder.getAnswerTimeout())
                {
                    jsonStr13['9'] = MCMAgentInfoBuilder.getAnswerTimeout();
                }
                if (!!MCMAgentInfoBuilder.getQueuePriority())
                {
                    jsonStr13['10'] = MCMAgentInfoBuilder.getQueuePriority();
                }
                if (!!MCMAgentInfoBuilder.getMaxImUser())
                {
                    jsonStr13['11'] = MCMAgentInfoBuilder.getMaxImUser();
                }
                if (!!MCMAgentInfoBuilder.getAgentServerMode())
                {
                    jsonStr13['12'] = MCMAgentInfoBuilder.getAgentServerMode();
                }
                jsonStr['13'] = jsonStr13;
                jsonStr = JSON.stringify(jsonStr);
                jsonStr = '{\"MCMData\":' + jsonStr + '}';
                return '{\"MsgLite\":{\"1\":' + YTX_CONFIG._prototype._mcmEventData._prototype + ',\"2\":' + jsonStr + ',\"3\":' + (YTX_CONFIG._generateClientNo(callback, onError)) + '}}'
            },
            _buildMCM_AgentEvt_KFOffWork: function (agentId, callback, onError)
            {
                if (!YTX_CONFIG._checkOnline(onError))
                {
                    return null
                }
                if (!agentId)
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = "param agentId is empty";
                    onError(resp);
                    return
                }
                var jsonStr = new Object();
                jsonStr['1'] = YTX_CONFIG._prototype._mcmEventData._mcmEventDef._AgentEvt_KFOffWork;
                jsonStr['10'] = agentId;
                jsonStr = JSON.stringify(jsonStr);
                jsonStr = '{\"MCMData\":' + jsonStr + '}';
                return '{\"MsgLite\":{\"1\":' + YTX_CONFIG._prototype._mcmEventData._prototype + ',\"2\":' + jsonStr + ',\"3\":' + (YTX_CONFIG._generateClientNo(callback, onError)) + '}}'
            },
            _buildMCM_AgentEvt_Ready: function (agentId, callback, onError)
            {
                if (!YTX_CONFIG._checkOnline(onError))
                {
                    return null
                }
                if (!agentId)
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = "param agentId is empty";
                    onError(resp);
                    return
                }
                var jsonStr = new Object();
                jsonStr['1'] = YTX_CONFIG._prototype._mcmEventData._mcmEventDef._AgentEvt_Ready;
                jsonStr['10'] = agentId;
                jsonStr = JSON.stringify(jsonStr);
                jsonStr = '{\"MCMData\":' + jsonStr + '}';
                return '{\"MsgLite\":{\"1\":' + YTX_CONFIG._prototype._mcmEventData._prototype + ',\"2\":' + jsonStr + ',\"3\":' + (YTX_CONFIG._generateClientNo(callback, onError)) + '}}'
            },
            _buildMCM_AgentEvt_NotReady: function (agentId, callback, onError)
            {
                if (!YTX_CONFIG._checkOnline(onError))
                {
                    return null
                }
                if (!agentId)
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = "param agentId is empty";
                    onError(resp);
                    return
                }
                var jsonStr = new Object();
                jsonStr['1'] = YTX_CONFIG._prototype._mcmEventData._mcmEventDef._AgentEvt_NotReady;
                jsonStr['10'] = agentId;
                jsonStr = JSON.stringify(jsonStr);
                jsonStr = '{\"MCMData\":' + jsonStr + '}';
                return '{\"MsgLite\":{\"1\":' + YTX_CONFIG._prototype._mcmEventData._prototype + ',\"2\":' + jsonStr + ',\"3\":' + (YTX_CONFIG._generateClientNo(callback, onError)) + '}}'
            },
            _buildMCM_AgentEvt_RejectUser: function (userAccount, ccpCustomData, agentId, callback, onError)
            {
                if (!YTX_CONFIG._checkOnline(onError))
                {
                    return null
                }
                if (!agentId)
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = "param agentId is empty";
                    onError(resp);
                    return
                }
                if (!userAccount)
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = 'param userAccount is empty';
                    onError(resp);
                    return
                }
                if (!ccpCustomData)
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = 'param ccpCustomData is empty';
                    onError(resp);
                    return
                }
                var jsonStr = new Object();
                jsonStr['1'] = YTX_CONFIG._prototype._mcmEventData._mcmEventDef._AgentEvt_RejectUser;
                jsonStr['4'] = userAccount;
                jsonStr['10'] = agentId;
                jsonStr['17'] = ccpCustomData;
                jsonStr = JSON.stringify(jsonStr);
                jsonStr = '{\"MCMData\":' + jsonStr + '}';
                return '{\"MsgLite\":{\"1\":' + YTX_CONFIG._prototype._mcmEventData._prototype + ',\"2\":' + jsonStr + ',\"3\":' + (YTX_CONFIG._generateClientNo(callback, onError)) + '}}'
            },
            _buildMCM_AgentEvt_TransKF: function (userAccount, osUnityAccount, transAgentId, agentId, callback, onError)
            {
                if (!YTX_CONFIG._checkOnline(onError))
                {
                    return null
                }
                if (!agentId)
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = "param agentId is empty";
                    onError(resp);
                    return
                }
                if (!userAccount)
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = 'param userAccount is empty';
                    onError(resp);
                    return
                }
                if (!osUnityAccount)
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = 'param osUnityAccount is empty';
                    onError(resp);
                    return
                }
                if (!transAgentId)
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = 'param transAgentId is empty';
                    onError(resp);
                    return
                }
                var jsonStr = new Object();
                jsonStr['1'] = YTX_CONFIG._prototype._mcmEventData._mcmEventDef._AgentEvt_TransKF;
                jsonStr['4'] = userAccount;
                jsonStr['5'] = osUnityAccount;
                jsonStr['10'] = agentId;
                jsonStr['11'] = transAgentId;
                jsonStr = JSON.stringify(jsonStr);
                jsonStr = '{\"MCMData\":' + jsonStr + '}';
                return '{\"MsgLite\":{\"1\":' + YTX_CONFIG._prototype._mcmEventData._prototype + ',\"2\":' + jsonStr + ',\"3\":' + (YTX_CONFIG._generateClientNo(callback, onError)) + '}}'
            },
            _buildMCM_AgentEvt_TransferQueue: function (userAccount, queueType, callback, onError)
            {
                if (!YTX_CONFIG._checkOnline(onError))
                {
                    return null
                }
                if (!userAccount)
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = 'param userAccount is empty';
                    onError(resp);
                    return
                }
                if (!queueType)
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = 'param queueType is empty';
                    onError(resp);
                    return
                }
                var jsonStr = new Object();
                jsonStr['1'] = YTX_CONFIG._prototype._mcmEventData._mcmEventDef._AgentEvt_TransferQueue;
                jsonStr['4'] = userAccount;
                jsonStr['18'] = queueType;
                jsonStr = JSON.stringify(jsonStr);
                jsonStr = '{\"MCMData\":' + jsonStr + '}';
                return '{\"MsgLite\":{\"1\":' + YTX_CONFIG._prototype._mcmEventData._prototype + ',\"2\":' + jsonStr + ',\"3\":' + (YTX_CONFIG._generateClientNo(callback, onError)) + '}}'
            },
            _buildMCM_AgentEvt_EnterCallService: function (userAccount, userPhone, callback, onError)
            {
                if (!YTX_CONFIG._checkOnline(onError))
                {
                    return null
                }
                if (!userAccount)
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = 'param userAccount is empty';
                    onError(resp);
                    return
                }
                if (!userPhone)
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = 'param userPhone is empty';
                    onError(resp);
                    return
                }
                var jsonStr = new Object();
                jsonStr['1'] = YTX_CONFIG._prototype._mcmEventData._mcmEventDef._AgentEvt_EnterCallService;
                jsonStr['4'] = userAccount;
                jsonStr['12'] = userPhone;
                jsonStr = JSON.stringify(jsonStr);
                jsonStr = '{\"MCMData\":' + jsonStr + '}';
                return '{\"MsgLite\":{\"1\":' + YTX_CONFIG._prototype._mcmEventData._prototype + ',\"2\":' + jsonStr + ',\"3\":' + (YTX_CONFIG._generateClientNo(callback, onError)) + '}}'
            },
            _buildMCM_AgentEvt_MonitorAgent: function (userAccount, agentId, callback, onError)
            {
                if (!YTX_CONFIG._checkOnline(onError))
                {
                    return null
                }
                if (!userAccount)
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = 'param userAccount is empty';
                    onError(resp);
                    return
                }
                if (!agentId)
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = "param agentId is empty";
                    onError(resp);
                    return
                }
                var jsonStr = new Object();
                jsonStr['1'] = YTX_CONFIG._prototype._mcmEventData._mcmEventDef._AgentEvt_MonitorAgent;
                jsonStr['4'] = userAccount;
                jsonStr['10'] = agentId;
                jsonStr = JSON.stringify(jsonStr);
                jsonStr = '{\"MCMData\":' + jsonStr + '}';
                return '{\"MsgLite\":{\"1\":' + YTX_CONFIG._prototype._mcmEventData._prototype + ',\"2\":' + jsonStr + ',\"3\":' + (YTX_CONFIG._generateClientNo(callback, onError)) + '}}'
            },
            _buildMCM_AgentEvt_CancelMonitorAgent: function (userAccount, agentId, callback, onError)
            {
                if (!YTX_CONFIG._checkOnline(onError))
                {
                    return null
                }
                if (!userAccount)
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = 'param userAccount is empty';
                    onError(resp);
                    return
                }
                if (!agentId)
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = "param agentId is empty";
                    onError(resp);
                    return
                }
                var jsonStr = new Object();
                jsonStr['1'] = YTX_CONFIG._prototype._mcmEventData._mcmEventDef._AgentEvt_CancelMonitorAgent;
                jsonStr['4'] = userAccount;
                jsonStr['10'] = agentId;
                jsonStr = JSON.stringify(jsonStr);
                jsonStr = '{\"MCMData\":' + jsonStr + '}';
                return '{\"MsgLite\":{\"1\":' + YTX_CONFIG._prototype._mcmEventData._prototype + ',\"2\":' + jsonStr + ',\"3\":' + (YTX_CONFIG._generateClientNo(callback, onError)) + '}}'
            },
            _buildMCM_AgentEvt_ForceTransfer: function (userAccount, superAgentId, agentId, transAgentId, callback, onError)
            {
                if (!YTX_CONFIG._checkOnline(onError))
                {
                    return null
                }
                if (!userAccount)
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = 'param userAccount is empty';
                    onError(resp);
                    return
                }
                if (!superAgentId)
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = 'param superAgentId is empty';
                    onError(resp);
                    return
                }
                if (!agentId)
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = 'param agentId is empty';
                    onError(resp);
                    return
                }
                if (!transAgentId)
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = 'param transAgentId is empty';
                    onError(resp);
                    return
                }
                var jsonStr = new Object();
                jsonStr['1'] = YTX_CONFIG._prototype._mcmEventData._mcmEventDef._AgentEvt_ForceTransfer;
                jsonStr['4'] = userAccount;
                jsonStr['23'] = superAgentId;
                jsonStr['10'] = agentId;
                jsonStr['11'] = transAgentId;
                jsonStr = JSON.stringify(jsonStr);
                jsonStr = '{\"MCMData\":' + jsonStr + '}';
                return '{\"MsgLite\":{\"1\":' + YTX_CONFIG._prototype._mcmEventData._prototype + ',\"2\":' + jsonStr + ',\"3\":' + (YTX_CONFIG._generateClientNo(callback, onError)) + '}}'
            },
            _buildMCM_AgentEvt_ForceEndService: function (userAccount, superAgentId, agentId, callback, onError)
            {
                if (!YTX_CONFIG._checkOnline(onError))
                {
                    return null
                }
                if (!agentId)
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = "param agentId is empty";
                    onError(resp);
                    return
                }
                if (!userAccount)
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = 'param userAccount is empty';
                    onError(resp);
                    return
                }
                if (!superAgentId)
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = 'param superAgentId is empty';
                    onError(resp);
                    return
                }
                var jsonStr = new Object();
                jsonStr['1'] = YTX_CONFIG._prototype._mcmEventData._mcmEventDef._AgentEvt_ForceEndService;
                jsonStr['4'] = userAccount;
                jsonStr['23'] = superAgentId;
                jsonStr['10'] = agentId;
                jsonStr = JSON.stringify(jsonStr);
                jsonStr = '{\"MCMData\":' + jsonStr + '}';
                return '{\"MsgLite\":{\"1\":' + YTX_CONFIG._prototype._mcmEventData._prototype + ',\"2\":' + jsonStr + ',\"3\":' + (YTX_CONFIG._generateClientNo(callback, onError)) + '}}'
            },
            _buildMCM_AgentEvt_QueryQueueInfo: function (queueType, callback, onError)
            {
                if (!YTX_CONFIG._checkOnline(onError))
                {
                    return null
                }
                if (!queueType)
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = 'param queueType is empty';
                    onError(resp);
                    return
                }
                var jsonStr = new Object();
                jsonStr['1'] = YTX_CONFIG._prototype._mcmEventData._mcmEventDef._AgentEvt_QueryQueueInfo;
                jsonStr['18'] = queueType;
                jsonStr = JSON.stringify(jsonStr);
                jsonStr = '{\"MCMData\":' + jsonStr + '}';
                return '{\"MsgLite\":{\"1\":' + YTX_CONFIG._prototype._mcmEventData._prototype + ',\"2\":' + jsonStr + ',\"3\":' + (YTX_CONFIG._generateClientNo(callback, onError)) + '}}'
            },
            _buildMCM_AgentEvt_QueryAgentInfo: function (agentId, callback, onError)
            {
                if (!YTX_CONFIG._checkOnline(onError))
                {
                    return null
                }
                if (!agentId)
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = "param agentId is empty";
                    onError(resp);
                    return
                }
                var jsonStr = new Object();
                jsonStr['1'] = YTX_CONFIG._prototype._mcmEventData._mcmEventDef._AgentEvt_QueryAgentInfo;
                jsonStr['10'] = agentId;
                jsonStr = JSON.stringify(jsonStr);
                jsonStr = '{\"MCMData\":' + jsonStr + '}';
                return '{\"MsgLite\":{\"1\":' + YTX_CONFIG._prototype._mcmEventData._prototype + ',\"2\":' + jsonStr + ',\"3\":' + (YTX_CONFIG._generateClientNo(callback, onError)) + '}}'
            },
            _buildMCM_AgentEvt_StartConf: function (userAccount, agentId, callback, onError)
            {
                if (!YTX_CONFIG._checkOnline(onError))
                {
                    return null
                }
                if (!agentId)
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = 'param agentId is empty';
                    onError(resp);
                    return
                }
                var jsonStr = new Object();
                jsonStr['1'] = YTX_CONFIG._prototype._mcmEventData._mcmEventDef._AgentEvt_StartConf;
                jsonStr['4'] = userAccount;
                jsonStr['10'] = agentId;
                jsonStr = JSON.stringify(jsonStr);
                jsonStr = '{\"MCMData\":' + jsonStr + '}';
                return '{\"MsgLite\":{\"1\":' + YTX_CONFIG._prototype._mcmEventData._prototype + ',\"2\":' + jsonStr + ',\"3\":' + (YTX_CONFIG._generateClientNo(callback, onError)) + '}}'
            },
            _buildMCM_AgentEvt_JoinConf: function (userAccount, agentId, callback, onError)
            {
                if (!YTX_CONFIG._checkOnline(onError))
                {
                    return null
                }
                if (!agentId)
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = 'param agentId is empty';
                    onError(resp);
                    return
                }
                var jsonStr = new Object();
                jsonStr['1'] = YTX_CONFIG._prototype._mcmEventData._mcmEventDef._AgentEvt_JoinConf;
                jsonStr['4'] = userAccount;
                jsonStr['10'] = agentId;
                jsonStr = JSON.stringify(jsonStr);
                jsonStr = '{\"MCMData\":' + jsonStr + '}';
                return '{\"MsgLite\":{\"1\":' + YTX_CONFIG._prototype._mcmEventData._prototype + ',\"2\":' + jsonStr + ',\"3\":' + (YTX_CONFIG._generateClientNo(callback, onError)) + '}}'
            },
            _buildMCM_AgentEvt_ExitConf: function (userAccount, agentId, callback, onError)
            {
                if (!YTX_CONFIG._checkOnline(onError))
                {
                    return null
                }
                if (!agentId)
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = 'param agentId is empty';
                    onError(resp);
                    return
                }
                var jsonStr = new Object();
                jsonStr['1'] = YTX_CONFIG._prototype._mcmEventData._mcmEventDef._AgentEvt_ExitConf;
                jsonStr['4'] = userAccount;
                jsonStr['10'] = agentId;
                jsonStr = JSON.stringify(jsonStr);
                jsonStr = '{\"MCMData\":' + jsonStr + '}';
                return '{\"MsgLite\":{\"1\":' + YTX_CONFIG._prototype._mcmEventData._prototype + ',\"2\":' + jsonStr + ',\"3\":' + (YTX_CONFIG._generateClientNo(callback, onError)) + '}}'
            },
            _buildMCM_AgentEvt_StartSessionTimer: function (userAccount, callback, onError)
            {
                if (!YTX_CONFIG._checkOnline(onError))
                {
                    return null
                }
                var jsonStr = new Object();
                jsonStr['1'] = YTX_CONFIG._prototype._mcmEventData._mcmEventDef._AgentEvt_StartSessionTimer;
                jsonStr['4'] = userAccount;
                jsonStr = JSON.stringify(jsonStr);
                jsonStr = '{\"MCMData\":' + jsonStr + '}';
                return '{\"MsgLite\":{\"1\":' + YTX_CONFIG._prototype._mcmEventData._prototype + ',\"2\":' + jsonStr + ',\"3\":' + (YTX_CONFIG._generateClientNo(callback, onError)) + '}}'
            },
            _buildMCM_AgentEvt_ForceJoinConf: function (userAccount, agentId, callback, onError)
            {
                if (!YTX_CONFIG._checkOnline(onError))
                {
                    return null
                }
                if (!agentId)
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = 'param agentId is empty';
                    onError(resp);
                    return
                }
                var jsonStr = new Object();
                jsonStr['1'] = YTX_CONFIG._prototype._mcmEventData._mcmEventDef._AgentEvt_ForceJoinConf;
                jsonStr['4'] = userAccount;
                jsonStr['10'] = agentId;
                jsonStr = JSON.stringify(jsonStr);
                jsonStr = '{\"MCMData\":' + jsonStr + '}';
                return '{\"MsgLite\":{\"1\":' + YTX_CONFIG._prototype._mcmEventData._prototype + ',\"2\":' + jsonStr + ',\"3\":' + (YTX_CONFIG._generateClientNo(callback, onError)) + '}}'
            },
            _buildMCM_AgentEvt_ReservedForUser: function (keyType, reservedKey, agentId, callback, onError)
            {
                if (!YTX_CONFIG._checkOnline(onError))
                {
                    return null
                }
                if (!agentId)
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = "param agentId is empty";
                    onError(resp);
                    return
                }
                var jsonStr = new Object();
                jsonStr['1'] = YTX_CONFIG._prototype._mcmEventData._mcmEventDef._AgentEvt_ReservedForUser;
                jsonStr['10'] = agentId;
                var ccpCustomData = {};
                ccpCustomData['keyType'] = keyType;
                ccpCustomData['reservedKey'] = reservedKey;
                jsonStr['17'] = ccpCustomData;
                jsonStr = JSON.stringify(jsonStr);
                jsonStr = '{\"MCMData\":' + jsonStr + '}';
                return '{\"MsgLite\":{\"1\":' + YTX_CONFIG._prototype._mcmEventData._prototype + ',\"2\":' + jsonStr + ',\"3\":' + (YTX_CONFIG._generateClientNo(callback, onError)) + '}}'
            },
            _buildMCM_AgentEvt_CancelReserved: function (keyType, reservedKey, agentId, callback, onError)
            {
                if (!YTX_CONFIG._checkOnline(onError))
                {
                    return null
                }
                if (!agentId)
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = "param agentId is empty";
                    onError(resp);
                    return
                }
                var jsonStr = new Object();
                jsonStr['1'] = YTX_CONFIG._prototype._mcmEventData._mcmEventDef._AgentEvt_CancelReserved;
                jsonStr['10'] = agentId;
                var ccpCustomData = {};
                ccpCustomData['keyType'] = keyType;
                ccpCustomData['reservedKey'] = reservedKey;
                jsonStr['17'] = ccpCustomData;
                jsonStr = JSON.stringify(jsonStr);
                jsonStr = '{\"MCMData\":' + jsonStr + '}';
                return '{\"MsgLite\":{\"1\":' + YTX_CONFIG._prototype._mcmEventData._prototype + ',\"2\":' + jsonStr + ',\"3\":' + (YTX_CONFIG._generateClientNo(callback, onError)) + '}}'
            },
            _buildMCM_AgentEvt_SerWithTheUser: function (osUnityAccount, userAccount, chanType, agentId, callback, onError)
            {
                if (!YTX_CONFIG._checkOnline(onError))
                {
                    return null
                }
                if (!agentId)
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = "param agentId is empty";
                    onError(resp);
                    return
                }
                if (!osUnityAccount)
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = 'param osUnityAccount is empty';
                    onError(resp);
                    return
                }
                if (!userAccount)
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = 'param userAccount is empty';
                    onError(resp);
                    return
                }
                if (!chanType)
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = 'param chanType is empty';
                    onError(resp);
                    return
                }
                var jsonStr = new Object();
                jsonStr['1'] = YTX_CONFIG._prototype._mcmEventData._mcmEventDef._AgentEvt_SerWithTheUser;
                jsonStr['10'] = agentId;
                jsonStr['5'] = osUnityAccount;
                jsonStr['4'] = userAccount;
                jsonStr['8'] = chanType;
                jsonStr = JSON.stringify(jsonStr);
                jsonStr = '{\"MCMData\":' + jsonStr + '}';
                return '{\"MsgLite\":{\"1\":' + YTX_CONFIG._prototype._mcmEventData._prototype + ',\"2\":' + jsonStr + ',\"3\":' + (YTX_CONFIG._generateClientNo(callback, onError)) + '}}'
            },
            _buildMCMEventData: function (userAccount, callback, onError)
            {
            },
            _buildSyncMessage: function (startVersion, endVersion, type, onError, repeat)
            {
                if (!YTX_CONFIG._checkOnline(onError, null))
                {
                    return null
                }
                if (isNaN(startVersion) || isNaN(endVersion) || (!!type && isNaN(type)))
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._PARAM_TYPE_ERR;
                    resp.msg = 'param startVersion or endVersion or type is not a number.';
                    onError(resp);
                    return
                }
                var sendJsonStr = new Object();
                if (endVersion - startVersion <= 10)
                {
                    sendJsonStr['1'] = startVersion + ',' + endVersion
                }
                else
                {
                    sendJsonStr['1'] = startVersion + ',' + (parseInt(startVersion) + 10)
                }
                if (!!type)
                {
                    sendJsonStr['2'] = type
                }
                sendJsonStr = JSON.stringify(sendJsonStr);
                var syncMsgStr = '{\"SyncMsg\":' + sendJsonStr + '}';
                return '{\"MsgLite\":{\"1\":' + YTX_CONFIG._prototype._syncMsg + ',\"2\":' + syncMsgStr + ',\"3\":' + (YTX_CONFIG._generateClientNo(null, onError, null, endVersion, type, repeat)) + '}}'
            },
            _buildGetNickByAcc: function (userAccount, callback, onError)
            {
                if (!YTX_CONFIG._checkOnline(onError))
                {
                    return null
                }
                if (!userAccount)
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._PARAM_TYPE_ERR;
                    resp.msg = "_buildGetNickByAcc():userAccount cann't be null!";
                    onError(resp);
                    return
                }
                ;
                var clientNo = YTX_CONFIG._generateClientNo(callback, onError);
                var sendStr = new Object();
                sendStr['1'] = userAccount;
                sendStr = JSON.stringify(sendStr);
                var queryPersonInfoStr = '{\"QueryPersonInfo\":' + sendStr + '}';
                return '{\"MsgLite\":{\"1\":' + YTX_CONFIG._prototype._getMyInfo + ',\"2\":' + queryPersonInfoStr + ',\"3\":' + clientNo + '}}'
            },
            _buildGetMyInfo: function (callback, onError)
            {
                if (!YTX_CONFIG._checkOnline(onError))
                {
                    return null
                }
                var clientNo = YTX_CONFIG._generateClientNo(callback, onError);
                return '{\"MsgLite\":{\"1\":' + YTX_CONFIG._prototype._getMyInfo + ',\"3\":' + clientNo + '}}'
            },
            _buildSetMyInfo: function (uploadPersonInfoBuilder, callback, onError)
            {
                if (!YTX_CONFIG._checkOnline(onError))
                {
                    return null
                }
                if (!uploadPersonInfoBuilder.getNickName())
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = 'upload personInfo,nickName is null';
                    onError(resp);
                    return
                }
                if (!!uploadPersonInfoBuilder.getBirth())
                {
                    var regx = /^(19|20)\d{2}-(1[0-2]|0[1-9])-(0[1-9]|[1-2][0-9]|3[0-1])$/;
                    if (regx.exec(uploadPersonInfoBuilder.getBirth()) == null)
                    {
                        var resp = {};
                        resp.code = YTX_CONFIG._errcode._PARAM_TYPE_ERR;
                        resp.msg = 'upload personInfo,birth is error, only accept format yyyy-MM-dd, eg:1990-01-01';
                        onError(resp);
                        return
                    }
                }
                if (!!uploadPersonInfoBuilder.getSex())
                {
                    var regx = /^(1|2)$/;
                    if (regx.exec(uploadPersonInfoBuilder.getSex()) == null)
                    {
                        var resp = {};
                        resp.code = YTX_CONFIG._errcode._PARAM_TYPE_ERR;
                        resp.msg = 'upload personInfo,sex is error, 1 is male and 2 is female';
                        onError(resp);
                        return
                    }
                }
                if (!!uploadPersonInfoBuilder.getSign() && uploadPersonInfoBuilder.getSign().length > 100)
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._PARAM_OUT_OF_LENGTH;
                    resp.msg = 'upload personInfo,sign is error, sign length must less than 100';
                    onError(resp);
                    return
                }
                var sendJsonStr = new Object();
                sendJsonStr['1'] = uploadPersonInfoBuilder.getNickName();
                if (!!uploadPersonInfoBuilder.getSex())
                {
                    sendJsonStr['2'] = parseInt(uploadPersonInfoBuilder.getSex())
                }
                if (!!uploadPersonInfoBuilder.getBirth())
                {
                    sendJsonStr['3'] = uploadPersonInfoBuilder.getBirth()
                }
                if (!!uploadPersonInfoBuilder.getSign())
                {
                    sendJsonStr['4'] = uploadPersonInfoBuilder.getSign()
                }
                sendJsonStr = JSON.stringify(sendJsonStr);
                var uploadPersonInfoStr = '{\"PersonInfo\":' + sendJsonStr + '}';
                return '{\"MsgLite\":{\"1\":' + YTX_CONFIG._prototype._setMyInfo + ',\"2\":' + uploadPersonInfoStr + ',\"3\":' + (YTX_CONFIG._generateClientNo(callback, onError)) + '}}'
            },
            _buildCreateGroup: function (createGroupBuilder, callback, onError)
            {
                if (!YTX_CONFIG._checkOnline(onError, null))
                {
                    return null
                }
                if (!createGroupBuilder || !createGroupBuilder.getGroupName() || !createGroupBuilder.getScope())
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = 'param groupName or scope is empty.';
                    onError(resp);
                    return
                }
                var sendJsonStr = new Object();
                sendJsonStr['1'] = YTX_CONFIG._userName;
                sendJsonStr['2'] = createGroupBuilder.getGroupName();
                sendJsonStr['3'] = createGroupBuilder.getGroupType();
                if (!!createGroupBuilder.getProvince())
                {
                    sendJsonStr['4'] = createGroupBuilder.getProvince()
                }
                if (!!createGroupBuilder.getCity())
                {
                    sendJsonStr['5'] = createGroupBuilder.getCity()
                }
                sendJsonStr['6'] = createGroupBuilder.getScope();
                if (!!createGroupBuilder.getDeclared())
                {
                    sendJsonStr['7'] = createGroupBuilder.getDeclared()
                }
                sendJsonStr['8'] = createGroupBuilder.getPermission();
                sendJsonStr['9'] = createGroupBuilder.getMode();
                if (!!createGroupBuilder.getGroupDomain())
                {
                    sendJsonStr['10'] = createGroupBuilder.getGroupDomain()
                }
                if (!!createGroupBuilder.getTarget())
                {
                    if (isNaN(createGroupBuilder.getTarget()))
                    {
                        var resp = {};
                        resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                        resp.msg = 'param target is not a number.';
                        onError(resp);
                        return
                    }
                    sendJsonStr['11'] = createGroupBuilder.getTarget()
                }
                sendJsonStr = JSON.stringify(sendJsonStr);
                var sendProto = '{\"CreateGroup\":' + sendJsonStr + '}';
                var clientNo = YTX_CONFIG._generateClientNo(callback, onError);
                return '{\"MsgLite\":{\"1\":' + YTX_CONFIG._prototype._createGroup + ',\"2\":' + sendProto + ',\"3\":' + (clientNo) + '}}'
            },
            _buildDismissGroup: function (dismissGroupBuilder, callback, onError)
            {
                if (!YTX_CONFIG._checkOnline(onError, null))
                {
                    return null
                }
                if (!dismissGroupBuilder || !dismissGroupBuilder.getGroupId())
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = 'param groupid is empty.';
                    onError(resp)
                }
                var sendJsonStr = new Object();
                sendJsonStr['2'] = dismissGroupBuilder.getGroupId();
                sendJsonStr = JSON.stringify(sendJsonStr);
                var sendProto = '{\"DismissGroup\":' + sendJsonStr + '}';
                var clientNo = YTX_CONFIG._generateClientNo(callback, onError);
                return '{\"MsgLite\":{\"1\":' + YTX_CONFIG._prototype._dismissGroup + ',\"2\":' + sendProto + ',\"3\":' + (clientNo) + '}}'
            },
            _buildInviteJoinGroupr: function (InviteGroupMemberBuilder, callback, onError)
            {
                if (!YTX_CONFIG._checkOnline(onError, null))
                {
                    return null
                }
                if (!InviteGroupMemberBuilder || !InviteGroupMemberBuilder.getGroupId() || !InviteGroupMemberBuilder.getMembers())
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = 'param groupid or members is empty.';
                    onError(resp)
                }
                if (!(InviteGroupMemberBuilder.getMembers() instanceof Array))
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._PARAM_TYPE_ERR;
                    resp.msg = 'param members is not an array.';
                    onError(resp);
                    return
                }
                var confirm = InviteGroupMemberBuilder.getConfirm();
                if (!confirm)
                {
                    confirm = 2
                }
                else
                {
                    if (isNaN(confirm) || (confirm != 1 && confirm != 2))
                    {
                        var resp = {};
                        resp.code = YTX_CONFIG._errcode._PARAM_TYPE_ERR;
                        resp.msg = 'param confirm is illegal';
                        onError(resp);
                        return
                    }
                }
                var sendJsonStr = new Object();
                sendJsonStr['2'] = InviteGroupMemberBuilder.getGroupId();
                if (!!InviteGroupMemberBuilder.getDeclared())
                {
                    sendJsonStr['3'] = InviteGroupMemberBuilder.getDeclared()
                }
                var members = InviteGroupMemberBuilder.getMembers();
                if (members.length <= 0)
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._PARAM_TYPE_ERR;
                    resp.msg = 'param members is illegal';
                    onError(resp);
                    return
                }
                sendJsonStr['4'] = members;
                sendJsonStr['5'] = InviteGroupMemberBuilder.getConfirm();
                sendJsonStr = JSON.stringify(sendJsonStr);
                var sendProto = '{\"InviteJoinGroup\":' + sendJsonStr + '}';
                var clientNo = YTX_CONFIG._generateClientNo(callback, onError);
                return '{\"MsgLite\":{\"1\":' + YTX_CONFIG._prototype._inviteJoinGroup + ',\"2\":' + sendProto + ',\"3\":' + (clientNo) + '}}'
            },
            _buildConfirmInviteJoinGroupr: function (ConfirmInviteGroupMemberBuilder, callback, onError)
            {
                if (!YTX_CONFIG._checkOnline(onError, null))
                {
                    return null
                }
                if (!ConfirmInviteGroupMemberBuilder || !ConfirmInviteGroupMemberBuilder.getGroupId() || !ConfirmInviteGroupMemberBuilder.getConfirm() || !ConfirmInviteGroupMemberBuilder.getInvitor())
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = 'param groupid or confirm or invitor is empty.';
                    onError(resp)
                }
                var confirm = ConfirmInviteGroupMemberBuilder.getConfirm();
                if (isNaN(confirm))
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._PARAM_TYPE_ERR;
                    resp.msg = 'param confirm is not a number.';
                    onError(resp);
                    return
                }
                var sendJsonStr = new Object();
                sendJsonStr['1'] = ConfirmInviteGroupMemberBuilder.getGroupId();
                sendJsonStr['2'] = ConfirmInviteGroupMemberBuilder.getInvitor();
                sendJsonStr['3'] = ConfirmInviteGroupMemberBuilder.getConfirm();
                sendJsonStr = JSON.stringify(sendJsonStr);
                var sendProto = '{\"ConfirmInviteJoinGroup\":' + sendJsonStr + '}';
                var clientNo = YTX_CONFIG._generateClientNo(callback, onError);
                return '{\"MsgLite\":{\"1\":' + YTX_CONFIG._prototype._confirmInviteJoin + ',\"2\":' + sendProto + ',\"3\":' + (clientNo) + '}}'
            },
            _buildQuitGroup: function (QuitGroupBuilder, callback, onError)
            {
                if (!YTX_CONFIG._checkOnline(onError, null))
                {
                    return null
                }
                if (!QuitGroupBuilder || !QuitGroupBuilder.getGroupId())
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = 'param groupid is empty.';
                    onError(resp);
                    return
                }
                var sendJsonStr = new Object();
                sendJsonStr['2'] = QuitGroupBuilder.getGroupId();
                sendJsonStr = JSON.stringify(sendJsonStr);
                var sendProto = '{\"QuitGroup\":' + sendJsonStr + '}';
                var clientNo = YTX_CONFIG._generateClientNo(callback, onError);
                return '{\"MsgLite\":{\"1\":' + YTX_CONFIG._prototype._quitGroup + ',\"2\":' + sendProto + ',\"3\":' + (clientNo) + '}}'
            },
            _buildGetGroupList: function (GetGroupListBuilder, callback, onError)
            {
                if (!YTX_CONFIG._checkOnline(onError, null))
                {
                    return null
                }
                if (!GetGroupListBuilder || !GetGroupListBuilder.getPageSize())
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = 'param pageSize is empty.';
                    onError(resp);
                    return
                }
                if (isNaN(GetGroupListBuilder.getPageSize()))
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._PARAM_TYPE_ERR;
                    resp.msg = 'param pageSize is not a number.';
                    onError(resp);
                    return
                }
                YTX_CONFIG._groupConfig._builder = GetGroupListBuilder;
                var sendJsonStr = new Object();
                if (!!GetGroupListBuilder.getGroupId())
                {
                    sendJsonStr['2'] = GetGroupListBuilder.getGroupId()
                }
                sendJsonStr['3'] = GetGroupListBuilder.getPageSize();
                if (!!GetGroupListBuilder.getTarget())
                {
                    sendJsonStr['4'] = GetGroupListBuilder.getTarget()
                }
                sendJsonStr = JSON.stringify(sendJsonStr);
                var sendProto = '{\"GetOwnerGroups\":' + sendJsonStr + '}';
                var clientNo = YTX_CONFIG._generateClientNo(callback, onError);
                return '{\"MsgLite\":{\"1\":' + YTX_CONFIG._prototype._getOwnGroups + ',\"2\":' + sendProto + ',\"3\":' + (clientNo) + '}}'
            },
            _buildGetGroupMemberList: function (GetGroupMemberListBuilder, callback, onError)
            {
                if (!YTX_CONFIG._checkOnline(onError, null))
                {
                    return null
                }
                if (!GetGroupMemberListBuilder || !GetGroupMemberListBuilder.getPageSize() || !GetGroupMemberListBuilder.getGroupId())
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = 'param pageSize or groupId is empty.';
                    onError(resp);
                    return
                }
                if (isNaN(GetGroupMemberListBuilder.getPageSize()))
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._PARAM_TYPE_ERR;
                    resp.msg = 'param pageSize is not a number.';
                    onError(resp);
                    return
                }
                YTX_CONFIG._groupConfig._builder = GetGroupMemberListBuilder;
                var sendJsonStr = new Object();
                sendJsonStr['1'] = GetGroupMemberListBuilder.getGroupId();
                if (!!GetGroupMemberListBuilder.getMemberId())
                {
                    sendJsonStr['3'] = GetGroupMemberListBuilder.getMemberId()
                }
                sendJsonStr['4'] = GetGroupMemberListBuilder.getPageSize();
                sendJsonStr = JSON.stringify(sendJsonStr);
                var sendProto = '{\"GetGroupMembers\":' + sendJsonStr + '}';
                var clientNo = YTX_CONFIG._generateClientNo(callback, onError);
                return '{\"MsgLite\":{\"1\":' + YTX_CONFIG._prototype._queryGroupMembers + ',\"2\":' + sendProto + ',\"3\":' + (clientNo) + '}}'
            },
            _buildJoinGroup: function (JoinGroupBuilder, callback, onError)
            {
                if (!YTX_CONFIG._checkOnline(onError, null))
                {
                    return null
                }
                if (!JoinGroupBuilder || !JoinGroupBuilder.getGroupId())
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = 'param groupId is empty';
                    onError(resp);
                    return
                }
                var sendJsonStr = new Object();
                sendJsonStr['2'] = JoinGroupBuilder.getGroupId();
                sendJsonStr['3'] = JoinGroupBuilder.getDeclared();
                sendJsonStr = JSON.stringify(sendJsonStr);
                var sendProto = '{\"JoinGroup\":' + sendJsonStr + '}';
                var clientNo = YTX_CONFIG._generateClientNo(callback, onError);
                return '{\"MsgLite\":{\"1\":' + YTX_CONFIG._prototype._joinGroup + ',\"2\":' + sendProto + ',\"3\":' + (clientNo) + '}}'
            },
            _buildConfirmJoinGroup: function (ConfirmJoinGroupBuilder, callback, onError)
            {
                if (!YTX_CONFIG._checkOnline(onError, null))
                {
                    return null
                }
                if (!ConfirmJoinGroupBuilder || !ConfirmJoinGroupBuilder.getGroupId() || !ConfirmJoinGroupBuilder.getMemberId() || !ConfirmJoinGroupBuilder.getConfirm())
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = 'param groupId or memberId or confirm is empty';
                    onError(resp);
                    return
                }
                var sendJsonStr = new Object();
                sendJsonStr['2'] = ConfirmJoinGroupBuilder.getGroupId();
                sendJsonStr['3'] = ConfirmJoinGroupBuilder.getMemberId();
                sendJsonStr['4'] = ConfirmJoinGroupBuilder.getConfirm();
                sendJsonStr = JSON.stringify(sendJsonStr);
                var sendProto = '{\"ConfirmJoinGroup\":' + sendJsonStr + '}';
                var clientNo = YTX_CONFIG._generateClientNo(callback, onError);
                return '{\"MsgLite\":{\"1\":' + YTX_CONFIG._prototype._confirmJoinGroup + ',\"2\":' + sendProto + ',\"3\":' + (clientNo) + '}}'
            },
            _buildGetGroupDetail: function (GetGroupDetailBuilder, callback, onError)
            {
                if (!YTX_CONFIG._checkOnline(onError, null))
                {
                    return null
                }
                if (!GetGroupDetailBuilder || !GetGroupDetailBuilder.getGroupId())
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = 'param groupId is empty.';
                    onError(resp);
                    return
                }
                var sendJsonStr = new Object();
                sendJsonStr['2'] = GetGroupDetailBuilder.getGroupId();
                sendJsonStr = JSON.stringify(sendJsonStr);
                var sendProto = '{\"GetGroupDetail\":' + sendJsonStr + '}';
                var clientNo = YTX_CONFIG._generateClientNo(callback, onError);
                return '{\"MsgLite\":{\"1\":' + YTX_CONFIG._prototype._getGroupDetail + ',\"2\":' + sendProto + ',\"3\":' + (clientNo) + '}}'
            },
            _buildSearchGroups: function (SearchGroupsBuilder, callback, onError)
            {
                if (!YTX_CONFIG._checkOnline(onError, null))
                {
                    return null
                }
                if (!SearchGroupsBuilder || !SearchGroupsBuilder.getSearchType() || !SearchGroupsBuilder.getKeywords)
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = 'param serachType or keyWord is empty.';
                    onError(resp);
                    return
                }
                var sendJsonStr = new Object();
                sendJsonStr['2'] = SearchGroupsBuilder.getSearchType();
                sendJsonStr['3'] = SearchGroupsBuilder.getKeywords();
                sendJsonStr = JSON.stringify(sendJsonStr);
                var sendProto = '{\"SearchGroups\":' + sendJsonStr + '}';
                var clientNo = YTX_CONFIG._generateClientNo(callback, onError);
                return '{\"MsgLite\":{\"1\":' + YTX_CONFIG._prototype._searchGroups + ',\"2\":' + sendProto + ',\"3\":' + (clientNo) + '}}'
            },
            _buildDeleteGroupMember: function (DeleteGroupMemberBuilder, callback, onError)
            {
                if (!YTX_CONFIG._checkOnline(onError, null))
                {
                    return null
                }
                if (!DeleteGroupMemberBuilder || !DeleteGroupMemberBuilder.getGroupId() || !DeleteGroupMemberBuilder.getMemberId())
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = 'param groupid or memberId is empty.';
                    onError(resp);
                    return
                }
                var sendJsonStr = new Object();
                sendJsonStr['2'] = DeleteGroupMemberBuilder.getGroupId();
                sendJsonStr['3'] = [DeleteGroupMemberBuilder.getMemberId()];
                sendJsonStr = JSON.stringify(sendJsonStr);
                var sendProto = '{\"DeleteGroupMember\":' + sendJsonStr + '}';
                var clientNo = YTX_CONFIG._generateClientNo(callback, onError);
                return '{\"MsgLite\":{\"1\":' + YTX_CONFIG._prototype._deleteGroupMember + ',\"2\":' + sendProto + ',\"3\":' + (clientNo) + '}}'
            },
            _buildForbidMemberSpeak: function (ForbidMemberSpeakBuilder, callback, onError)
            {
                if (!YTX_CONFIG._checkOnline(onError, null))
                {
                    return null
                }
                if (!ForbidMemberSpeakBuilder || !ForbidMemberSpeakBuilder.getGroupId() || !ForbidMemberSpeakBuilder.getMemberId())
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = 'param groupid or memberId is empty.';
                    onError(resp);
                    return
                }
                var sendJsonStr = new Object();
                sendJsonStr['2'] = ForbidMemberSpeakBuilder.getGroupId();
                sendJsonStr['3'] = ForbidMemberSpeakBuilder.getMemberId();
                sendJsonStr['4'] = ForbidMemberSpeakBuilder.getForbidState();
                sendJsonStr = JSON.stringify(sendJsonStr);
                var sendProto = '{\"ForbidMemberSpeak\":' + sendJsonStr + '}';
                var clientNo = YTX_CONFIG._generateClientNo(callback, onError);
                return '{\"MsgLite\":{\"1\":' + YTX_CONFIG._prototype._forbidMemberSpeak + ',\"2\":' + sendProto + ',\"3\":' + (clientNo) + '}}'
            },
            _buildSetGroupMessageRule: function (SetGroupMessageRuleBuilder, callback, onError)
            {
                if (!YTX_CONFIG._checkOnline(onError, null))
                {
                    return null
                }
                if (!SetGroupMessageRuleBuilder || !SetGroupMessageRuleBuilder.getGroupId())
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = 'param groupId is empty.';
                    onError(resp);
                    return
                }
                var sendJsonStr = new Object();
                sendJsonStr['1'] = SetGroupMessageRuleBuilder.getGroupId();
                if (!!SetGroupMessageRuleBuilder.getIsNotice())
                {
                    sendJsonStr['2'] = SetGroupMessageRuleBuilder.getIsNotice()
                }
                if (!!SetGroupMessageRuleBuilder.getIsApplePush())
                {
                    sendJsonStr['3'] = SetGroupMessageRuleBuilder.getIsApplePush()
                }
                sendJsonStr = JSON.stringify(sendJsonStr);
                var sendProto = '{\"SetGroupMessagRule\":' + sendJsonStr + '}';
                var clientNo = YTX_CONFIG._generateClientNo(callback, onError);
                return '{\"MsgLite\":{\"1\":' + YTX_CONFIG._prototype._setGroupMessageRule + ',\"2\":' + sendProto + ',\"3\":' + (clientNo) + '}}'
            },
            _buildQueryGroupMemberCard: function (QueryGroupMemberCard, callback, onError)
            {
                if (!YTX_CONFIG._checkOnline(onError, null))
                {
                    return null
                }
                if (!QueryGroupMemberCard || !QueryGroupMemberCard.getMemberId() || !QueryGroupMemberCard.getBelong())
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = 'param memberId or groupid is empty.';
                    onError(resp);
                    return
                }
                var sendJsonStr = new Object();
                sendJsonStr['1'] = QueryGroupMemberCard.getMemberId();
                sendJsonStr['2'] = QueryGroupMemberCard.getBelong();
                sendJsonStr = JSON.stringify(sendJsonStr);
                var sendProto = '{\"QueryGroupMemberCard\":' + sendJsonStr + '}';
                var clientNo = YTX_CONFIG._generateClientNo(callback, onError);
                return '{\"MsgLite\":{\"1\":' + YTX_CONFIG._prototype._queryGroupMemberCard + ',\"2\":' + sendProto + ',\"3\":' + (clientNo) + '}}'
            },
            _buildModifyMemberCard: function (ModifyMemberCardBuilder, callback, onError)
            {
                if (!YTX_CONFIG._checkOnline(onError, null))
                {
                    return null
                }
                if (!ModifyMemberCardBuilder || !ModifyMemberCardBuilder.getMember() || !ModifyMemberCardBuilder.getBelong())
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = 'param memberId or groupId is empty.';
                    onError(resp);
                    return
                }
                var sendJsonStr = new Object();
                sendJsonStr['1'] = ModifyMemberCardBuilder.getBelong();
                sendJsonStr['2'] = ModifyMemberCardBuilder.getMember();
                if (!!ModifyMemberCardBuilder.getDisplay())
                {
                    sendJsonStr['3'] = ModifyMemberCardBuilder.getDisplay()
                }
                if (!!ModifyMemberCardBuilder.getPhone())
                {
                    sendJsonStr['4'] = ModifyMemberCardBuilder.getPhone()
                }
                if (!!ModifyMemberCardBuilder.getMail())
                {
                    sendJsonStr['5'] = ModifyMemberCardBuilder.getMail()
                }
                if (!!ModifyMemberCardBuilder.getRemark())
                {
                    sendJsonStr['6'] = ModifyMemberCardBuilder.getRemark()
                }
                sendJsonStr = JSON.stringify(sendJsonStr);
                var sendProto = '{\"ModifyMemberCard\":' + sendJsonStr + '}';
                var clientNo = YTX_CONFIG._generateClientNo(callback, onError);
                return '{\"MsgLite\":{\"1\":' + YTX_CONFIG._prototype._modifyMemberCard + ',\"2\":' + sendProto + ',\"3\":' + (clientNo) + '}}'
            },
            _buildModifyGroup: function (ModifyGroupBuilder, callback, onError)
            {
                if (!YTX_CONFIG._checkOnline(onError, null))
                {
                    return null
                }
                if (!ModifyGroupBuilder || !ModifyGroupBuilder.getGroupId() || !ModifyGroupBuilder.getGroupName())
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = 'param groupid or groupName is empty.';
                    onError(resp);
                    return
                }
                var sendJsonStr = new Object();
                sendJsonStr['2'] = ModifyGroupBuilder.getGroupId();
                sendJsonStr['3'] = ModifyGroupBuilder.getGroupName();
                if (!!ModifyGroupBuilder.getType())
                {
                    sendJsonStr['4'] = ModifyGroupBuilder.getType()
                }
                if (!!ModifyGroupBuilder.getProvince())
                {
                    sendJsonStr['5'] = ModifyGroupBuilder.getProvince()
                }
                if (!!ModifyGroupBuilder.getCity())
                {
                    sendJsonStr['6'] = ModifyGroupBuilder.getCity()
                }
                if (!!ModifyGroupBuilder.getScope())
                {
                    sendJsonStr['7'] = ModifyGroupBuilder.getScope()
                }
                if (!!ModifyGroupBuilder.getDeclared() || "" == ModifyGroupBuilder.getDeclared())
                {
                    sendJsonStr['8'] = ModifyGroupBuilder.getDeclared()
                }
                if (!!ModifyGroupBuilder.getPermission())
                {
                    sendJsonStr['9'] = ModifyGroupBuilder.getPermission()
                }
                if (!!ModifyGroupBuilder.getGroupDomain())
                {
                    sendJsonStr['10'] = ModifyGroupBuilder.getGroupDomain()
                }
                sendJsonStr = JSON.stringify(sendJsonStr);
                var sendProto = '{\"ModifyGroup\":' + sendJsonStr + '}';
                var clientNo = YTX_CONFIG._generateClientNo(callback, onError);
                return '{\"MsgLite\":{\"1\":' + YTX_CONFIG._prototype._modifyGroup + ',\"2\":' + sendProto + ',\"3\":' + (clientNo) + '}}'
            },
            _buildConfirmMsg: function ()
            {
                if (!YTX_CONFIG._checkOnline(function ()
                    {
                    }, null))
                {
                    return null
                }
                if (YTX_CONFIG._msgVersion == 0 || YTX_CONFIG._syncMsgVersion == YTX_CONFIG._msgVersion)
                {
                    return null
                }
                var sendJsonStr = new Object();
                sendJsonStr['1'] = YTX_CONFIG._msgVersion;
                sendJsonStr = JSON.stringify(sendJsonStr);
                var sendProto = '{\"ConfirmMsg\":' + sendJsonStr + '}';
                var clientNo = YTX_CONFIG._generateClientNo(function ()
                {
                    YTX_CONFIG._syncMsgVersion = YTX_CONFIG._msgVersion
                }, function ()
                {
                });
                return '{\"MsgLite\":{\"1\":' + YTX_CONFIG._prototype._confirmMsg + ',\"2\":' + sendProto + ',\"3\":' + (clientNo) + '}}'
            },
            _getStateTime: null,
            _getStateCount: 0,
            _buildGetUserState: function (GetUserStateBuilder, callback, onError)
            {
                if (!YTX_CONFIG._checkOnline(onError, null))
                {
                    return null
                }
                var curTime = new Date().getTime();
                if (!YTX_CONFIG._protobuf._getStateTime)
                {
                    YTX_CONFIG._protobuf._getStateTime = curTime;
                    YTX_CONFIG._protobuf._getStateCount = 0
                }
                else
                {
                    if (((curTime - YTX_CONFIG._protobuf._getStateTime) > 3000))
                    {
                        YTX_CONFIG._protobuf._getStateCount = 0;
                        YTX_CONFIG._protobuf._getStateTime = curTime
                    }
                }
                if (YTX_CONFIG._protobuf._getStateCount++ > 0)
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._REQUEST_TOO_FREQUENT;
                    resp.msg = 'request too frequent, please wait a while.';
                    onError(resp);
                    return
                }
                var sendJsonStr = new Object();
                if (!!GetUserStateBuilder.getUseracc())
                {
                    if (GetUserStateBuilder.getUseracc() instanceof Array)
                    {
                        if (GetUserStateBuilder.getUseracc().length == 0)
                        {
                            var resp = {};
                            resp.code = YTX_CONFIG._errcode._CHARSET_ILLEGAl;
                            resp.msg = "getUserState param is null";
                            onError(resp);
                            return
                        }
                        else
                        {
                            sendJsonStr['1'] = GetUserStateBuilder.getUseracc()
                        }
                    }
                    else
                    {
                        sendJsonStr['1'] = GetUserStateBuilder.getUseracc()
                    }
                }
                else
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._CHARSET_ILLEGAl;
                    resp.msg = "param userAccount param is null";
                    onError(resp);
                    return
                }
                sendJsonStr = JSON.stringify(sendJsonStr);
                var sendProto = '{\"GetUserState\":' + sendJsonStr + '}';
                var clientNo = YTX_CONFIG._generateClientNo(callback, onError);
                return '{\"MsgLite\":{\"1\":' + YTX_CONFIG._prototype._getUserState + ',\"2\":' + sendProto + ',\"3\":' + (clientNo) + '}}'
            },
            _buildSetGroupMemberRole: function (setGroupMemberRoleBuilder, callback, onError)
            {
                if (!YTX_CONFIG._checkOnline(onError, null))
                {
                    return null
                }
                var sendJsonStr = new Object();
                sendJsonStr['1'] = setGroupMemberRoleBuilder.getGroupId();
                sendJsonStr['2'] = setGroupMemberRoleBuilder.getMemberId();
                sendJsonStr['3'] = setGroupMemberRoleBuilder.getRole();
                sendJsonStr = JSON.stringify(sendJsonStr);
                var sendProto = '{\"SetGroupMemberRole\":' + sendJsonStr + '}';
                var clientNo = YTX_CONFIG._generateClientNo(callback, onError);
                return '{\"MsgLite\":{\"1\":' + YTX_CONFIG._prototype._setGroupMemberRole + ',\"2\":' + sendProto + ',\"3\":' + (clientNo) + '}}'
            },
            _buildGetFileSource: function (url, callback, onError)
            {
                if (!YTX_CONFIG._checkOnline(onError, null))
                {
                    return null
                }
                ;
                return '{\"FileUrl\":"' + url + '"}'
            },
            _buildGetHistoryMessage: function (GetHistoryMsgBuilder, callback, onError)
            {
                if (!YTX_CONFIG._checkOnline(onError, null))
                {
                    return null
                }
                if (!GetHistoryMsgBuilder.getOperator())
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = 'operator is empty';
                    onError(resp);
                    return
                }
                if (!GetHistoryMsgBuilder.getTalker())
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = 'talker is empty';
                    onError(resp);
                    return
                }
                var sig = YTX_CONFIG._fileSig;
                var msgId = GetHistoryMsgBuilder.getMsgId();
                if (GetHistoryMsgBuilder.getOperator() == 1)
                {
                    var version = msgId;
                    if (version.indexOf("|") > 0)
                    {
                        version = version.substring(version.indexOf("|") + 1)
                    }
                }
                var sendJsonStr = new Object();
                sendJsonStr['1'] = YTX_CONFIG._appid;
                sendJsonStr['2'] = YTX_CONFIG._userName;
                if (!!version)
                {
                    sendJsonStr['3'] = version
                }
                else
                {
                    sendJsonStr['4'] = msgId
                }
                sendJsonStr['5'] = GetHistoryMsgBuilder.getPageSize();
                sendJsonStr['6'] = GetHistoryMsgBuilder.getTalker();
                sendJsonStr['7'] = GetHistoryMsgBuilder.getOrder();
                sendJsonStr = JSON.stringify(sendJsonStr);
                var sendProto = '{\"History\":' + sendJsonStr + '}';
                var clientNo = YTX_CONFIG._generateClientNo(callback, onError);
                return '{\"Http\":{\"1\":3,\"2\":' + sendProto + ',\"3\":' + clientNo + ',\"4\":\"' + sig + '\"}}'
            },
            _CallEventData: function (callEvent, callId, isVoipCall, called, caller, userData, strSDP, reason)
            {
                this._callEvent = callEvent;
                this._callId = callId;
                this._isVoipCall = isVoipCall;
                this._called = called;
                this._caller = caller;
                this._userData = userData;
                this._strSDP = strSDP;
                this._reason = reason;
                this.setCallEvent = function (callEvent)
                {
                    this._callEvent = callEvent
                };
                this.setCallId = function (callId)
                {
                    this._callId = callId
                };
                this.setIsVoipCall = function (isVoipCall)
                {
                    this._isVoipCall = isVoipCall
                };
                this.setCalled = function (called)
                {
                    this._called = called
                };
                this.setCaller = function (caller)
                {
                    this._caller = caller
                };
                this.setUserData = function (userData)
                {
                    this._userData = userData
                };
                this.setStrSDP = function (strSDP)
                {
                    this._strSDP = strSDP
                };
                this.setReason = function (reason)
                {
                    this._reason = reason
                };
                this.getCallEvent = function ()
                {
                    return this._callEvent
                };
                this.getCallId = function ()
                {
                    return this._callId
                };
                this.getIsVoipCall = function ()
                {
                    return this._isVoipCall
                };
                this.getCalled = function ()
                {
                    return this._called
                };
                this.getCaller = function ()
                {
                    return this._caller
                };
                this.getUserData = function ()
                {
                    return this._userData
                };
                this.getStrSDP = function ()
                {
                    return this._strSDP
                };
                this.getReason = function ()
                {
                    return this._reason
                }
            },
            _buildCallEvent: function (CallEventBuilder, callback, onError)
            {
                if (!YTX_CONFIG._checkOnline(onError, null))
                {
                    return null
                }
                if (!CallEventBuilder || !CallEventBuilder.getCaller() || !CallEventBuilder.getCalled())
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = 'param called or caller is empty';
                    onError(resp);
                    return
                }
                var sendJsonStr = new Object();
                sendJsonStr['1'] = CallEventBuilder.getCallEvent();
                sendJsonStr['2'] = CallEventBuilder.getCallId();
                if (CallEventBuilder.getIsVoipCall() == 0 || CallEventBuilder.getIsVoipCall() == 1 || CallEventBuilder.getIsVoipCall() == 2)
                {
                    sendJsonStr['3'] = CallEventBuilder.getIsVoipCall()
                }
                sendJsonStr['5'] = CallEventBuilder.getCalled();
                sendJsonStr['7'] = CallEventBuilder.getCaller();
                if (!!CallEventBuilder.getReason())
                {
                    sendJsonStr['10'] = CallEventBuilder.getReason()
                }
                if (!!CallEventBuilder.getUserData())
                {
                    sendJsonStr['13'] = CallEventBuilder.getUserData()
                }
                if (!!CallEventBuilder.getStrSDP())
                {
                    sendJsonStr['17'] = CallEventBuilder.getStrSDP()
                }
                sendJsonStr = JSON.stringify(sendJsonStr);
                var sendProto = '{\"CallEventDataInner\":' + sendJsonStr + '}';
                var clientNo = YTX_CONFIG._generateClientNo(callback, onError, CallEventBuilder.getCallId());
                if (!!YTX_CONFIG._voipCallData._msgRouterMap[CallEventBuilder.getCallId()])
                {
                    return '{\"MsgLite\":{\"1\":' + YTX_CONFIG._prototype._callRoute + ',\"2\":' + sendProto + ',\"3\":' + (clientNo) + ',\"9":\"' + YTX_CONFIG._voipCallData._msgRouterMap[CallEventBuilder.getCallId()] + '\"}}'
                }
                else
                {
                    return '{\"MsgLite\":{\"1\":' + YTX_CONFIG._prototype._callRoute + ',\"2\":' + sendProto + ',\"3\":' + (clientNo) + '}}'
                }
            },
            _buildDeleteReadMsg: function (DeleteReadMsgBuilder, callback, onError)
            {
                if (!YTX_CONFIG._checkOnline(onError, null))
                {
                    return null
                }
                if (!DeleteReadMsgBuilder.getMsgid())
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = 'param msgId is empty.';
                    onError(resp);
                    return
                }
                var version = DeleteReadMsgBuilder.getMsgid();
                var idx = version.indexOf('|');
                if (idx > 0)
                {
                    version = version.substr(idx + 1)
                }
                var sendJsonStr = new Object();
                sendJsonStr['1'] = version;
                sendJsonStr['2'] = YTX_CONFIG._userName;
                sendJsonStr = JSON.stringify(sendJsonStr);
                var sendProto = '{\"MsgOperation\":' + sendJsonStr + '}';
                var clientNo = YTX_CONFIG._generateClientNo(callback, onError);
                return '{\"MsgLite\":{\"1\":' + YTX_CONFIG._prototype._deleteReadMsg + ',\"2\":' + sendProto + ',\"3\":' + (clientNo) + '}}'
            },
            _buildMsgOperation: function (msgOperationBuilder, callback, onError)
            {
                if (!YTX_CONFIG._checkOnline(onError, null))
                {
                    return null
                }
                var sendJsonStr = new Object();
                sendJsonStr['2'] = msgOperationBuilder.getMsgId();
                if (!!msgOperationBuilder.getType())
                {
                    sendJsonStr['3'] = msgOperationBuilder.getType()
                }
                sendJsonStr = JSON.stringify(sendJsonStr);
                var clientNo = YTX_CONFIG._generateClientNo(callback, onError);
                var sendProto = '{\"MsgOperation\":' + sendJsonStr + '}';
                return '{\"MsgLite\":{\"1\":' + YTX_CONFIG._prototype._msgOperation + ',\"2\":' + sendProto + ',\"3\":' + (clientNo) + '}}'
            },
            _buildGetRecentContactList: function (GetRecentContactListBuilder, callback, onError)
            {
                if (!YTX_CONFIG._checkOnline(onError, null))
                {
                    return null
                }
                var sig = YTX_CONFIG._fileSig;
                var sendJsonStr = new Object();
                sendJsonStr['1'] = YTX_CONFIG._appid;
                sendJsonStr['2'] = YTX_CONFIG._userName;
                if (GetRecentContactListBuilder.getTime())
                {
                    sendJsonStr['3'] = GetRecentContactListBuilder.getTime()
                }
                if (GetRecentContactListBuilder.getLimit())
                {
                    sendJsonStr['4'] = GetRecentContactListBuilder.getLimit()
                }
                sendJsonStr = JSON.stringify(sendJsonStr);
                var sendProto = '{\"RecentlyContactsList\":' + sendJsonStr + '}';
                var clientNo = YTX_CONFIG._generateClientNo(callback, onError);
                return '{\"Http\":{\"1\":4,\"2\":' + sendProto + ',\"3\":' + clientNo + ',\"4\":\"' + sig + '\"}}'
            },
            _parseLoginResp: function (obj)
            {
                var data = obj["2"];
                data = data["UserAuthResp"];
                var resp = {};
                resp.authState = data["1"];
                resp.kickoffText = data["2"];
                resp.connectorId = data["3"];
                resp.version = (!!data["4"]) ? data["4"] : 0;
                resp.transferPolicy = data["6"];
                resp.pversion = data["7"];
                resp.softVersion = data["8"];
                resp.historyver = (!!data["10"]) ? data["10"] : 0;
                resp.authToken = data["11"];
                resp.ipSpeedTestPolicy = data["12"];
                return resp
            },
            _parseCodeResp: function (obj)
            {
                var resp = {};
                resp.code = obj["6"];
                return resp
            },
            _parseSendMsgResp: function (obj, request)
            {
                var data = obj["2"];
                var resp = {};
                if (!!data && !!data["SendMsgResp"])
                {
                    data = data["SendMsgResp"];
                    resp.token = data["1"];
                    resp.url = data["2"]
                }
                var clientNo = obj["3"];
                var msgId = request.orignMsgId;
                var msgClientNo = request.msgId;
                resp.msgId = msgId;
                resp.msgClientNo = msgClientNo;
                return resp
            },
            _parseSendMsgRespErr: function (obj, request)
            {
                var resp = {};
                var clientNo = obj["3"];
                resp.msgClientNo = request.msgId;
                resp.msgId = request.orignMsgId;
                resp.code = obj["6"];
                return resp
            },
            _parsePushMsgResp: function (obj)
            {
                var data = obj["2"];
                data = data["PushMsg"];
                var resp = {};
                resp.version = data["1"];
                resp.msgType = (!!data["2"]) ? data["2"] : 1;
                resp.sessionId = data["3"];
                if (!!data["4"])
                {
                    resp.msgContent = Base64.decode(data["4"])
                }
                else
                {
                    resp.msgContent = ''
                }
                resp.msgSender = data["5"];
                resp.msgReceiver = data["6"];
                resp.msgDomain = data["7"];
                resp.msgFileName = data["8"];
                if (!!data["9"])
                {
                    var fileUrl = data["9"];
                    if (!fileUrl.startWith('http'))
                    {
                        if (fileUrl.indexOf('_thum') > 0)
                        {
                            fileUrl = fileUrl.substring(0, fileUrl.indexOf('_thum'))
                        }
                        var len = YTX_CONFIG._lvs_servers.length;
                        var Range = len - 1;
                        var Rand = Math.random();
                        var idx = Math.round(Rand * Range);
                        var lvsServer = Base64.decode(YTX_CONFIG._lvs_servers[idx]);
                        fileUrl = lvsServer + fileUrl
                    }
                    resp.msgFileUrl = fileUrl;
                    if (resp.msgType == 3)
                    {
                        resp.msgFileUrlThum = resp.msgFileUrl + '_thum'
                    }
                }
                resp.msgDateCreated = data["10"];
                resp.senderNickName = data["13"];
                resp.mcmEvent = 0;
                if (!!data["14"])
                {
                    resp.msgFileSize = data["14"]
                }
                if (!!data["15"])
                {
                    if (resp.msgType == 11)
                    {
                        var data = Base64.decode(data["15"]);
                        data = JSON.parse(data);
                        if (!!data["isat"])
                        {
                            resp.isAtMsg = true
                        }
                    }
                }
                if (!!data["16"])
                {
                    resp.senderNick = data[16]
                }
                return resp
            },
            _parseMCM_Msg: function (data)
            {
                var msg = {};
                msg.mcmEvent = data["1"];
                msg.version = data["2"];
                msg.chanType = data["8"];
                msg.addrJson = data["19"];
                if (msg.mcmEvent == YTX_CONFIG._prototype._mcmEventData._mcmEventDef._AgentEvt_SendMCM)
                {
                    msg.msgSender = data["5"];
                    msg.msgReceiver = (!!data["4"]) ? data["4"] : YTX_CONFIG._userName
                }
                else if (msg.mcmEvent == YTX_CONFIG._prototype._mcmEventData._mcmEventDef._UserEvt_SendMSG)
                {
                    msg.msgSender = data["4"];
                    msg.msgReceiver = (!!data["5"]) ? data["5"] : YTX_CONFIG._userName
                }
                msg.msgDomain = data["16"];
                msg.msgDateCreated = data["3"];
                msg.msgId = msg.msgDateCreated + '|' + msg.version;
                if (!!data["6"])
                {
                    var msgInfos = data["6"];
                    if (!!msgInfos && msgInfos.length > 0)
                    {
                        var msgInfo = msgInfos[0];
                        msg.msgType = msgInfo["1"];
                        msg.msgContent = msgInfo["2"];
                        msg.msgFileName = msgInfo["4"];
                        if (!!msgInfo["3"])
                        {
                            var fileUrl = msgInfo["3"];
                            if (fileUrl.indexOf('_thum') > 0)
                            {
                                fileUrl = fileUrl.substring(0, fileUrl.indexOf('_thum'))
                            }
                            if (msg.msgType == 2)
                            {
                                fileUrl = fileUrl.substring(0, fileUrl.lastIndexOf('.')) + '.wav'
                            }
                            var len = YTX_CONFIG._lvs_servers.length;
                            var Range = len - 1;
                            var Rand = Math.random();
                            var idx = Math.round(Rand * Range);
                            var lvsServer = Base64.decode(YTX_CONFIG._lvs_servers[idx]);
                            msg.msgFileUrl = lvsServer + fileUrl;
                            if (msg.msgType == 3)
                            {
                                msg.msgFileUrlThum = msg.msgFileUrl + '_thum'
                            }
                        }
                    }
                }
                return msg
            },
            _parseMCMNotice_Msg: function (data)
            {
                var msg = {};
                msg.mcmEvent = data["1"];
                msg.version = data["2"];
                msg.msgDateCreated = data["3"];
                msg.msgId = msg.msgDateCreated + '|' + msg.version;
                if (!!data["4"])
                {
                    msg.userAccount = data["4"]
                }
                if (!!data["5"])
                {
                    msg.osUnityAccount = data["5"]
                }
                if (!!data["6"])
                {
                    var msgInfos = data["6"];
                    if (!!msgInfos && msgInfos.length > 0)
                    {
                        var msgInfo = msgInfos[0];
                        var m = {};
                        m.msgType = msgInfo["1"];
                        m.msgContent = msgInfo["2"];
                        m.msgFileUrl = msgInfo["3"];
                        if (!!msgInfo["3"])
                        {
                            var fileUrl = msgInfo["3"];
                            if (fileUrl.indexOf('_thum') > 0)
                            {
                                fileUrl = fileUrl.substring(0, fileUrl.indexOf('_thum'))
                            }
                            if (m.msgType == 2)
                            {
                                fileUrl = fileUrl.substring(0, fileUrl.lastIndexOf('.')) + '.wav'
                            }
                            var len = YTX_CONFIG._lvs_servers.length;
                            var Range = len - 1;
                            var Rand = Math.random();
                            var idx = Math.round(Rand * Range);
                            var lvsServer = Base64.decode(YTX_CONFIG._lvs_servers[idx]);
                            m.msgFileUrl = lvsServer + fileUrl;
                            if (m.msgType == 3)
                            {
                                m.msgFileUrlThum = msg.msgFileUrl + '_thum'
                            }
                        }
                        m.msgFileName = msgInfo["4"];
                        msg.MSGData = m
                    }
                }
                if (!!data["7"])
                {
                    var m = {};
                    var d = data["7"];
                    m.notifyDes = d["1"];
                    var items = new Array();
                    var d2 = d["2"];
                    for (var i in d2)
                    {
                        var itemObj = d2[i];
                        var item = {};
                        item.key = itemObj["1"];
                        item.value = itemObj["2"];
                        items.push(item)
                    }
                    m.selectItems = items;
                    msg.userIRCN = m
                }
                if (!!data["8"])
                {
                    msg.chanType = data["8"]
                }
                if (!!data["9"])
                {
                    msg.agentAccount = data["9"]
                }
                if (!!data["10"])
                {
                    msg.agentId = data["10"]
                }
                if (!!data["11"])
                {
                    msg.transAgentId = data["11"]
                }
                if (!!data["12"])
                {
                    msg.userPhone = data["12"]
                }
                if (!!data["13"])
                {
                    var m = {};
                    var d = data["13"];
                    m.agentId = d["1"];
                    m.imState = d["2"];
                    m.telState = d["3"];
                    m.number = d["4"];
                    m.pushVoipacc = d["5"];
                    m.queueType = d["6"];
                    m.userInfoCallbackurl = d["7"];
                    m.delayCall = d["8"];
                    m.answerTimeout = d["9"];
                    m.queuePriority = d["10"];
                    m.maxImUser = d["11"];
                    m.agentServerMode = d["12"];
                    msg.agentInfo = m
                }
                if (!!data["14"])
                {
                    var m = {};
                    var d = data["14"];
                    m.optResult = d["1"];
                    m.optRetDes = d["2"];
                    m.optUserData = d["3"];
                    msg.agentStateOpt = m
                }
                if (!!data["15"])
                {
                    msg.appId = data["15"]
                }
                if (!!data["16"])
                {
                    msg.userData = data["16"]
                }
                if (!!data["17"])
                {
                    msg.ccpCustomData = data["17"]
                }
                if (!!data["18"])
                {
                    msg.queueType = data["18"]
                }
                if (!!data["19"])
                {
                    msg.msgJsonData = data["19"]
                }
                if (!!data["20"])
                {
                    msg.CCSType = data["20"]
                }
                if (!!data["21"])
                {
                    msg.nickName = data["21"]
                }
                if (!!data["22"])
                {
                    msg.serviceCap = data["22"]
                }
                return msg
            },
            _parseNoticeMsg: function (obj)
            {
                var domain = obj.msgDomain;
                domain = Base64.decode(domain).replace(new RegExp(/(')/g), "\"");
                var domainInfo = JSON.parse(domain);
                var resp = {};
                resp.auditType = domainInfo.auditType;
                resp.groupId = domainInfo.groupId;
                resp.groupName = domainInfo.groupName;
                resp.declared = domainInfo.declared;
                resp.confirm = domainInfo.confirm;
                resp.ext = domainInfo.ext;
                resp.version = obj.version;
                resp.serviceNo = obj.msgSender;
                resp.target = domainInfo.target;
                if (domainInfo.auditType == 2 || domainInfo.auditType == 4 || domainInfo.auditType == 10)
                {
                    resp.admin = domainInfo.member;
                    resp.adminName = domainInfo.nickName
                }
                else if (domainInfo["auditType"] == 11)
                {
                    resp.admin = domainInfo.admin;
                    resp.member = domainInfo.member;
                    resp.memberName = domainInfo.nickName
                }
                else
                {
                    resp.member = domainInfo.member;
                    resp.memberName = domainInfo.nickName
                }
                return resp
            },
            _parsePushMsgNotifyResp: function (obj)
            {
                var data = obj["2"];
                data = data["PushMsgNotify"];
                var resp = {};
                resp.version = data["1"];
                return resp
            },
            _parseMsgNotify: function (obj)
            {
                var domain = obj.msgDomain;
                var domainInfo = JSON.parse(domain);
                var msgId = domainInfo.msgid;
                var resp = {};
                resp.msgType = obj.msgType;
                resp.sender = obj.msgSender;
                resp.msgId = msgId;
                resp.dateCreated = obj.dateCreated;
                return resp
            },
            _parseSyncMsgResp: function (obj, request)
            {
                var data = obj["2"];
                data = data["SyncMsgResp"];
                var resp = new Array();
                var recVersion = 0;
                for (var i in data)
                {
                    var orign = data[i];
                    var msg = {};
                    msg.version = orign["1"];
                    if (recVersion < msg.version)
                    {
                        recVersion = msg.version
                    }
                    msg.msgType = (!!orign["2"]) ? orign["2"] : 1;
                    msg.msgContent = orign["4"];
                    if (!!orign["4"])
                    {
                        msg.msgContent = Base64.decode(orign["4"])
                    }
                    else
                    {
                        msg.msgContent = ''
                    }
                    msg.msgSender = orign["5"];
                    msg.sessionId = orign["3"];
                    msg.msgReceiver = orign["6"];
                    msg.msgDomain = orign["7"];
                    msg.msgFileName = orign["8"];
                    if (!!orign["9"])
                    {
                        var fileUrl = orign["9"];
                        if (fileUrl.indexOf('_thum') > 0)
                        {
                            fileUrl = fileUrl.substring(0, fileUrl.indexOf('_thum'))
                        }
                        if (msg.msgType == 2)
                        {
                            fileUrl = fileUrl.substring(0, fileUrl.lastIndexOf('.')) + '.wav'
                        }
                        var len = YTX_CONFIG._lvs_servers.length;
                        var Range = len - 1;
                        var Rand = Math.random();
                        var idx = Math.round(Rand * Range);
                        var lvsServer = Base64.decode(YTX_CONFIG._lvs_servers[idx]);
                        msg.msgFileUrl = lvsServer + fileUrl;
                        if (msg.msgType == 3)
                        {
                            msg.msgFileUrlThum = msg.msgFileUrl + '_thum'
                        }
                    }
                    msg.msgDateCreated = orign["10"];
                    if (!!orign["13"])
                    {
                        msg.mcmEvent = orign["13"]
                    }
                    else
                    {
                        msg.mcmEvent = 0
                    }
                    if (!!orign["14"])
                    {
                        msg.msgFileSize = orign["14"]
                    }
                    if (!!orign["15"])
                    {
                        msg.isAtMsg = Base64.decode(orign["15"])
                    }
                    if (!!orign["16"])
                    {
                        msg.msgSenderNick = orign["16"]
                    }
                    resp.push(msg)
                }
                return resp
            },
            _parseGetHistoryMsg: function (obj)
            {
                var resp = new Array();
                var data = obj["2"];
                for (var i in data)
                {
                    var orign = data[i];
                    var result = {};
                    if (orign.msgType == YTX_CONFIG._prototype._msg_CMD)
                    {
                        var msg = YTX_CONFIG._protobuf._parseNoticeMsg(orign);
                        var you_sender = msg.serviceNo;
                        var groupId = msg.groupId;
                        var name = '系统通知';
                        var groupName = msg.groupName;
                        var version = msg.msgId;
                        var peopleId = msg.member;
                        var people = (!!msg.memberName) ? msg.memberName : msg.member;
                        var you_msgContent = '';
                        var auditType = msg.auditType;
                        var groupTarget = (msg.target == 2) ? "群组" : "讨论组";
                        if (1 == auditType)
                        {
                            you_msgContent = '[' + people + ']申请加入' + groupTarget + '[' + groupName + ']'
                        }
                        else if (2 == auditType)
                        {
                            you_msgContent = '[' + groupName + ']管理员邀请您加入' + groupTarget
                        }
                        else if (3 == auditType)
                        {
                            you_msgContent = '[' + people + ']直接加入群组[' + groupName + ']'
                        }
                        else if (4 == auditType)
                        {
                            you_msgContent = '管理员解散了群组[' + groupName + ']'
                        }
                        else if (5 == auditType)
                        {
                            you_msgContent = '[' + people + ']退出了' + groupTarget + '[' + groupName + ']'
                        }
                        else if (6 == auditType)
                        {
                            you_msgContent = '[' + groupName + ']管理员将[' + people + ']踢出' + groupTarget
                        }
                        else if (7 == auditType)
                        {
                            you_msgContent = '管理员同意[' + people + ']加入群组[' + groupName + ']的申请'
                        }
                        else if (8 == auditType)
                        {
                            if (2 != obj.confirm)
                            {
                                you_msgContent = '[' + people + ']拒绝了群组[' + groupName + ']的邀请'
                            }
                            else
                            {
                                you_msgContent = '[' + people + ']同意了管理员的邀请，加入群组[' + groupName + ']'
                            }
                        }
                        else if (10 == auditType)
                        {
                            you_msgContent = '管理员修改' + groupTarget + '[' + groupName + ']信息'
                        }
                        else if (11 == auditType)
                        {
                            you_msgContent = '用户[' + people + ']修改群组成员名片'
                        }
                        else if (12 == auditType)
                        {
                            you_msgContent = '用户[' + people + ']成为' + groupTarget + '[' + groupName + ']管理员'
                        }
                        else
                        {
                            you_msgContent = '未知type[' + auditType + ']'
                        }
                        result.msgContent = you_msgContent;
                        result.msgType = orign.msgType;
                        result.msgSender = name;
                        result.msgId = orign.msgDateCreated + '|' + orign.version
                    }
                    else
                    {
                        if (!!orign.version)
                        {
                            result.msgId = orign.msgDateCreated + '|' + orign.version
                        }
                        else
                        {
                            result.msgId = orign.msgId
                        }
                        result.msgContent = orign.msgContent;
                        result.msgSender = orign.msgSender;
                        result.msgReceiver = orign.msgReceiver;
                        result.msgDomain = orign.msgDomain;
                        if (orign.msgFileName)
                        {
                            result.msgFileName = orign.msgFileName
                        }
                        if (!!orign.msgFileUrl)
                        {
                            var fileUrl = orign.msgFileUrl;
                            if (fileUrl.indexOf('_thum') > 0)
                            {
                                fileUrl = fileUrl.substring(0, fileUrl.indexOf('_thum'))
                            }
                            if (orign.msgType == 2)
                            {
                                fileUrl = fileUrl.substring(0, fileUrl.lastIndexOf('.')) + '.wav'
                            }
                            var len = YTX_CONFIG._lvs_servers.length;
                            var Range = len - 1;
                            var Rand = Math.random();
                            var idx = Math.round(Rand * Range);
                            var lvsServer = Base64.decode(YTX_CONFIG._lvs_servers[idx]);
                            result.msgFileUrl = lvsServer + fileUrl;
                            if (result.msgType == 3)
                            {
                                result.msgFileUrlThum = msg.msgFileUrl + '_thum'
                            }
                        }
                    }
                    result.msgDateCreated = orign.msgDateCreated;
                    if (!!orign.msgFileSize)
                    {
                        result.msgFileSize = orign.msgFileSize
                    }
                    if (!!orign.mcmEvent)
                    {
                        result.mcmEvent = orign.mcmEvent
                    }
                    else
                    {
                        result.mcmEvent = 0
                    }
                    resp.push(result)
                }
                return resp
            },
            _parseGetMyInfo: function (obj)
            {
                var data = obj["2"];
                data = data["PersonInfoResp"];
                var resp = {};
                resp.version = data["1"];
                resp.nickName = data["2"];
                resp.sex = data["3"];
                resp.birth = data["4"];
                resp.sign = data["5"];
                return resp
            },
            _parseMcmMsg: function (obj)
            {
                var data = obj["2"];
                if (!data)
                {
                    return
                }
                data = data["MCMData"];
                var mcmEvent = data["1"];
                if (mcmEvent == YTX_CONFIG._prototype._mcmEventData._mcmEventDef._AgentEvt_SendMCM || mcmEvent == YTX_CONFIG._prototype._mcmEventData._mcmEventDef._UserEvt_SendMSG)
                {
                    var resp = YTX_CONFIG._protobuf._parseMCM_Msg(data);
                    YTX_CONFIG._mcmListener(resp)
                }
                else
                {
                    var resp = YTX_CONFIG._protobuf._parseMCMNotice_Msg(data);
                    YTX_CONFIG._mcmNoticeListener(resp)
                }
            },
            _parseCreateGroupResp: function (obj)
            {
                var data = obj["2"];
                if (!data)
                {
                    return
                }
                data = data["CreateGroupResp"];
                var msg = {};
                msg.data = data["1"];
                return msg
            },
            _parseGetGroupListResp: function (obj, callback, onErr)
            {
                var data = obj["2"];
                if (!data)
                {
                    callback(YTX_CONFIG._groupConfig._groupArray);
                    YTX_CONFIG._groupConfig._groupArray = [];
                    return
                }
                data = data["GetOwnerGroupsResp"];
                data = data["1"];
                for (var i in data)
                {
                    var simpleObj = data[i];
                    var simpleGroup = {};
                    simpleGroup.groupId = simpleObj["1"];
                    simpleGroup.name = simpleObj["2"];
                    simpleGroup.owner = simpleObj["3"];
                    simpleGroup.permission = simpleObj["4"];
                    simpleGroup.isNotice = simpleObj["5"];
                    simpleGroup.memberCount = simpleObj["6"];
                    simpleGroup.scope = simpleObj["7"];
                    simpleGroup.dateCreated = simpleObj["8"];
                    simpleGroup.target = simpleObj["9"];
                    YTX_CONFIG._groupConfig._groupArray.push(simpleGroup)
                }
                if (data.length == YTX_CONFIG._groupConfig._builder.getPageSize())
                {
                    var groupId = data[data.length - 1]["1"];
                    var GetGroupListBuilder = YTX_CONFIG._groupConfig._builder;
                    GetGroupListBuilder.setGroupId(groupId);
                    RL_YTX.getGroupList(GetGroupListBuilder, callback, onErr)
                }
                else
                {
                    callback(YTX_CONFIG._groupConfig._groupArray);
                    YTX_CONFIG._groupConfig._groupArray = []
                }
            },
            _parseGetGroupMemberListResp: function (obj, callback, onErr)
            {
                var data = obj["2"];
                if (!data)
                {
                    callback(YTX_CONFIG._groupConfig._groupMemberArray);
                    YTX_CONFIG._groupConfig._groupMemberArray = [];
                    return
                }
                data = data["GetGroupMembersResp"];
                var groupId = data["1"];
                data = data["2"];
                for (var i in data)
                {
                    var obj = data[i];
                    var member = {};
                    member.member = obj["1"];
                    member.nickName = obj["2"];
                    member.speakState = obj["3"];
                    member.role = obj["4"];
                    member.sex = obj["5"];
                    YTX_CONFIG._groupConfig._groupMemberArray.push(member)
                }
                if (data.length == YTX_CONFIG._groupConfig._builder.getPageSize())
                {
                    var memberId = data[data.length - 1]["1"];
                    var GetGroupMemberListBuilder = YTX_CONFIG._groupConfig._builder;
                    GetGroupMemberListBuilder.setMemberId(memberId);
                    RL_YTX.getGroupMemberList(GetGroupMemberListBuilder, callback, onErr)
                }
                else
                {
                    callback(YTX_CONFIG._groupConfig._groupMemberArray);
                    YTX_CONFIG._groupConfig._groupMemberArray = []
                }
            },
            _parseGetGroupDetailResp: function (obj)
            {
                var data = obj["2"];
                var resp = {};
                data = data["GetGroupDetailResp"];
                resp.creator = data["1"];
                resp.groupName = data["2"];
                resp.type = data["3"];
                resp.province = data["4"];
                resp.city = data["5"];
                resp.scope = data["6"];
                resp.declared = data["7"];
                resp.dateCreated = data["8"];
                resp.numbers = data["9"];
                resp.isNotice = data["10"];
                resp.permission = data["11"];
                resp.groupDomain = data["12"];
                resp.isApplePush = data["13"];
                resp.target = data["14"];
                return resp
            },
            _parseSearchGroupsResp: function (obj)
            {
                var data = obj["2"];
                var resp = new Array();
                if (!data)
                {
                    return resp
                }
                data = data["SearchGroupsResp"];
                data = data["1"];
                for (var i in data)
                {
                    var simpleObj = data[i];
                    var simpleGroup = {};
                    simpleGroup.groupId = simpleObj["1"];
                    simpleGroup.name = simpleObj["2"];
                    simpleGroup.owner = simpleObj["3"];
                    simpleGroup.permission = simpleObj["4"];
                    simpleGroup.declared = simpleObj["5"];
                    simpleGroup.memberCount = simpleObj["6"];
                    simpleGroup.scope = simpleObj["7"];
                    resp.push(simpleGroup)
                }
                return resp
            },
            _parseQueryGroupMemberCard: function (obj)
            {
                var data = obj["2"];
                var resp = {};
                if (!data)
                {
                    return resp
                }
                data = data["QueryGroupMemberCardResp"];
                resp.member = data["1"];
                resp.groupid = data["2"];
                resp.display = data["3"];
                resp.phone = data["4"];
                resp.mail = data["5"];
                resp.remark = data["6"];
                resp.speakState = data["7"];
                resp.role = data["8"];
                resp.sex = data["9"];
                return resp
            },
            _parseKickOffResp: function (obj)
            {
                var data = obj["2"];
                data = data["UserAuthResp"];
                var resp = {};
                resp.code = 4;
                resp.msg = data["2"];
                return resp
            },
            _parseGetUserState: function (obj)
            {
                var data = obj["2"];
                var resp = {};
                if (!data)
                {
                    return resp
                }
                data = data["GetUserStateResp"] ? data["GetUserStateResp"] : data["GetMultiUserStateResp"][0]["GetUserStateResp"];
                resp.useracc = data["1"];
                resp.network = data["2"];
                resp.state = data["3"];
                resp.device = data["4"];
                return resp
            },
            _parseGetUserState_multy: function (obj)
            {
                var data;
                var resp = {};
                if (!!obj["2"]["GetMultiUserStateResp"])
                {
                    data = obj["2"]["GetMultiUserStateResp"];
                    if (!data)
                    {
                        data = obj["2"]["GetUserStateResp"];
                        if (!data)
                        {
                            return resp
                        }
                        else
                        {
                            resp.useracc = data["1"];
                            resp.network = data["2"];
                            resp.state = data["3"];
                            resp.device = data["4"]
                        }
                    }
                    else
                    {
                        resp = [];
                        for (var i = 0; i < data.length; i++)
                        {
                            var dataPer = data[i]["GetUserStateResp"];
                            var respPer = {};
                            respPer.useracc = dataPer["1"];
                            respPer.network = dataPer["2"];
                            respPer.state = dataPer["3"];
                            respPer.device = dataPer["4"];
                            resp.push(respPer)
                        }
                    }
                }
                else
                {
                    resp = [];
                    var dataPer = obj["2"]["GetUserStateResp"];
                    var respPer = {};
                    if (!!data)
                    {
                        return resp;
                    }
                    respPer.useracc = dataPer["1"];
                    respPer.network = dataPer["2"];
                    respPer.state = dataPer["3"];
                    respPer.device = dataPer["4"];
                    resp.push(respPer)
                }
                return resp
            },
            _parseCallEventData: function (obj)
            {
                var data = obj["2"];
                var resp = {};
                if (!data)
                {
                    return resp
                }
                data = data["CallEventData"];
                var resp;
                resp = new YTX_CONFIG._protobuf._CallEventData(data["1"], data["2"], data["3"], data["5"], data["7"], data["13"], data["17"], data["10"]);
                return resp
            },
            _parseGetRecentContactList: function (obj)
            {
                var resp = new Array();
                var data = obj["2"];
                for (var i in data)
                {
                    var orign = data[i];
                    var result = {};
                    var userAcc = orign.sessionId;
                    var name = orign.sessionName;
                    var time = orign.dateCreated;
                    result.name = name;
                    result.time = time;
                    result.contact = userAcc;
                    resp.push(result)
                }
                return resp
            }
        },
        _logout: function ()
        {
            YTX_CONFIG._token = null;
            YTX_CONFIG._userName = null;
            YTX_CONFIG._userPwd = null;
            YTX_CONFIG._imei = null;
            for (var i in YTX_CONFIG._clientMap)
            {
                var request = YTX_CONFIG._clientMap[i];
                if (!request)
                {
                    return
                }
                try
                {
                    clearTimeout(request.timeout)
                } catch (e)
                {
                    console.log("Cannot read property 'timeout' of undefined")
                }
            }
            YTX_CONFIG._clientMap = {};
            YTX_CONFIG._sessionId = null;
            YTX_CONFIG._currentSession = null;
            YTX_CONFIG._ClientNo = 0;
            YTX_CONFIG._sendMsgId = 0;
            YTX_CONFIG._msgVersion = 0;
            YTX_CONFIG._syncMsgVersion = 0;
            YTX_CONFIG._maxMsgVersion = 0;
            YTX_CONFIG._syncMsgPorcessing = false;
            YTX_CONFIG._receiveMsgBuf = [];
            YTX_CONFIG._isReconnect = false;
            YTX_CONFIG._loginStatus = 1;
            YTX_CONFIG._isConnect = false;
            if (YTX_CONFIG._socket.close)
            {
                YTX_CONFIG._socket.close()
            }
            YTX_CONFIG._socket = null;
            window.clearInterval(YTX_CONFIG._intervalId);
            YTX_CONFIG._intervalId = null;
            RL_YTX.photo.cancel();
            RL_YTX.audio.cancel()
        },
        _connectStateChange: function (code, msg)
        {
            if (YTX_CONFIG._connectStatListener)
            {
                var resp = {};
                resp.code = code;
                resp.msg = msg;
                YTX_CONFIG._connectStatListener(resp)
            }
        },
        _onShortAuthFail: function (callback)
        {
            YTX_CONFIG._log(YTX_CONFIG._logLev._INFO, "shrot autl fail, complete auth");
            YTX_CONFIG._isReconnect = true;
            if (YTX_CONFIG._userPwd)
            {
                YTX_CONFIG._initScoket(3, callback, function ()
                {
                })
            }
            else
            {
                YTX_CONFIG._initScoket(1, callback, function ()
                {
                })
            }
        },
        _reconnect: function (callback)
        {
            YTX_CONFIG._connectStateChange(2, "reconnect to server");
            YTX_CONFIG._isReconnect = true;
            YTX_CONFIG._initScoket(2, callback, function ()
            {
            }, null, null, true)
        },
        _sendFile: function (fileInfo, content, receiver, msgType, msgId, msgDomain, type, callback, onError, progress, fileName, orignMsgId)
        {
            if (!YTX_CONFIG._checkOnline(onError, orignMsgId, msgId))
            {
                YTX_CONFIG._ClientNo++;
                return
            }
            if (!fileInfo || !receiver || !msgType)
            {
                var resp = {};
                resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                resp.msgId = orignMsgId;
                resp.msgClientNo = msgId;
                resp.msg = 'param file or receiver or type is empty';
                onError(resp);
                return
            }
            var sendStatus = 1;
            if (!(fileInfo instanceof File) && !(fileInfo instanceof Blob))
            {
                var resp = {};
                resp.code = YTX_CONFIG._errcode._FILE_PARAM_ERROR;
                resp.msgId = orignMsgId;
                resp.msgClientNo = msgId;
                resp.msg = 'param file is illegal';
                onError(resp);
                return
            }
            if (fileInfo.size >= YTX_CONFIG._maxFileLen)
            {
                var resp = {};
                resp.code = YTX_CONFIG._errcode._FILE_TOO_LARGE;
                resp.msgId = orignMsgId;
                resp.msgClientNo = msgId;
                resp.msg = 'param file is too large.';
                onError(resp);
                return
            }
            var tId = setTimeout(function ()
            {
                if (sendStatus == 2)
                {
                    return
                }
                sendStatus = 3;
                var resp = {};
                if (YTX_CONFIG._loginStatus == 2)
                {
                    YTX_CONFIG._loginStatus = 1
                }
                resp.code = YTX_CONFIG._errcode._RESP_TIME_OUT;
                resp.msgId = orignMsgId;
                resp.msgClientNo = msgId;
                resp.msg = 'connec to fileserver time out.';
                onError(resp)
            }, YTX_CONFIG._fileTimeOutSecond * 1000);
            var fileurl = Base64.decode(YTX_CONFIG._file_server_url);
            var ws = new WebSocket(fileurl);
            ws.onopen = function (event)
            {
                if (sendStatus == 3)
                {
                    ws.close();
                    return
                }
                sendStatus = 2;
                YTX_CONFIG._log(YTX_CONFIG._logLev._INFO, "connect to file socket");
                var sendStr = YTX_CONFIG._protobuf._buildSendFileMsgStart(fileInfo, null, receiver, msgType, orignMsgId, msgDomain, type, onError, fileName, msgId);
                if (!sendStr)
                {
                    return
                }
                YTX_CONFIG._log(YTX_CONFIG._logLev._INFO, sendStr);
                ws.send(sendStr);
                var reader = new FileReader();
                reader.readAsArrayBuffer(fileInfo);
                reader.onload = function loaded(evt)
                {
                    var binaryString = evt.target.result;
                    var start = 0;
                    var total = binaryString.byteLength;
                    var buf = 10 * 1024;
                    while (start < total)
                    {
                        var part;
                        var end = start + buf;
                        if (end > total)
                        {
                            end = total
                        }
                        if (binaryString.slice)
                        {
                            part = binaryString.slice(start, end)
                        }
                        else if (binaryString.mozSlice)
                        {
                            part = binaryString.mozSlice(start, end)
                        }
                        else if (binaryString.webkitSlice)
                        {
                            part = binaryString.webkitSlice(start, end)
                        }
                        else
                        {
                            part = binaryString;
                            start = total
                        }
                        try
                        {
                            ws.send(part)
                        } catch (e)
                        {
                            console.log("发送文件失败，file websocket已经关闭" + e)
                        }
                        progress(start, total, msgId);
                        start = end
                    }
                    progress(total, total, msgId);
                    sendStr = YTX_CONFIG._protobuf._buildSendFileMsgEnd(callback, onError, msgId, orignMsgId);
                    if (!sendStr)
                    {
                        return
                    }
                    ws.send(sendStr)
                }
            };
            ws.onmessage = function (event)
            {
                if (!!tId)
                {
                    clearTimeout(tId)
                }
                YTX_CONFIG._log(YTX_CONFIG._logLev._INFO, 'file client received a message');
                YTX_CONFIG._log(YTX_CONFIG._logLev._INFO, event.data);
                var data = JSON.parse(event.data);
                data = data["state"];
                var request = YTX_CONFIG._clientMap[data["2"]];
                if (!!request)
                {
                    var resp = {};
                    resp.msgId = orignMsgId;
                    resp.msgClientNo = msgId;
                    resp.fileUrl = Base64.decode(YTX_CONFIG._lvs_servers) + data["3"];
                    try
                    {
                        clearTimeout(request.timeout)
                    } catch (e)
                    {
                        console.log("Cannot read property 'timeout' of undefined")
                    }
                    var callback = request.callback;
                    var onError = request.onError;
                    if (data["1"] == "000000")
                    {
                        callback(resp)
                    }
                    else
                    {
                        var resp = {};
                        resp.msgId = orignMsgId;
                        resp.msgClientNo = msgId;
                        resp.code = data["1"];
                        resp.msg = "send file err";
                        onError(resp)
                    }
                }
                else
                {
                    YTX_CONFIG._log(YTX_CONFIG._logLev._INFO, 'file client request is null')
                }
                ws.close()
            };
            ws.onclose = function (event)
            {
                YTX_CONFIG._log(YTX_CONFIG._logLev._INFO, 'file client socket has closed', event)
            }
        },
        _heartBeat: function ()
        {
            if (!YTX_CONFIG._isReconnect)
            {
                var heartBeatStr = YTX_CONFIG._protobuf._buildHeartBeat();
                YTX_CONFIG._sendMsg(heartBeatStr)
            }
            else if (!YTX_CONFIG._isConnecting)
            {
                YTX_CONFIG._reconnect(function ()
                {
                })
            }
        },
        _heartBeatCallBack: function (obj)
        {
            YTX_CONFIG._heartBeatErrNum = 0;
            if (!!obj)
            {
                clearTimeout(obj)
            }
            YTX_CONFIG._log(YTX_CONFIG._logLev._INFO, "heartBeat succ")
        },
        _heartBeatCallBackErr: function (times)
        {
            YTX_CONFIG._log(YTX_CONFIG._logLevStat._INFO, "heart beak err");
            if ((!YTX_CONFIG._isConnect) || (YTX_CONFIG._loginStatus == 1) || times > 3)
            {
                if (YTX_CONFIG._loginStatus == 3)
                {
                    YTX_CONFIG._connectStateChange(1, "connect closeed")
                }
                YTX_CONFIG._loginStatus = 1;
                YTX_CONFIG._socket.close();
                YTX_CONFIG._socket = null;
                YTX_CONFIG._isConnect = false;
                YTX_CONFIG._isReconnect = true;
                YTX_CONFIG._reconnect(function ()
                {
                });
                if (!YTX_CONFIG._failIntervalId)
                {
                    YTX_CONFIG._failIntervalId = window.setInterval(YTX_CONFIG._heartBeat, YTX_CONFIG._failHeartBeatInterval * 1000)
                }
                if (!!YTX_CONFIG._intervalId)
                {
                    clearInterval(YTX_CONFIG._intervalId);
                    YTX_CONFIG._intervalId = null
                }
            }
        },
        _confirmMsg: function ()
        {
            var confirmStr = YTX_CONFIG._protobuf._buildConfirmMsg();
            if (!!confirmStr)
            {
                YTX_CONFIG._sendMsg(confirmStr)
            }
        },
        _getTimeStamp: function ()
        {
            var now = new Date();
            var timestamp = now.getFullYear() + '' + ((now.getMonth() + 1) >= 10 ? (now.getMonth() + 1) : "0" + (now.getMonth() + 1)) + (now.getDate() >= 10 ? now.getDate() : "0" + now.getDate()) + (now.getHours() >= 10 ? now.getHours() : "0" + now.getHours()) + (now.getMinutes() >= 10 ? now.getMinutes() : "0" + now.getMinutes()) + (now.getSeconds() >= 10 ? now.getSeconds() : "0" + now.getSeconds());
            return timestamp
        },
        _releaseVoip: function ()
        {
            if (!!YTX_CONFIG._voipCallData._localMediaStream)
            {
                YTX_CONFIG.util.stopMediaStream(YTX_CONFIG._voipCallData._localMediaStream)
            }
            if (YTX_CONFIG._voipCallData._peerConnection != null)
            {
                if (YTX_CONFIG._voipCallData._peerConnection.signalingState != "closed")
                {
                    YTX_CONFIG._voipCallData._peerConnection.close();
                    YTX_CONFIG._voipCallData._peerConnection = null
                }
                YTX_CONFIG._voipCallData._voipOtherView.srcObject = null;
                YTX_CONFIG._voipCallData._voipOtherView.src = "";
                YTX_CONFIG._voipCallData._voipOtherView = null;
                if (YTX_CONFIG._voipCallData._voipLocalView)
                {
                    YTX_CONFIG._voipCallData._voipLocalView.srcObject = null;
                    YTX_CONFIG._voipCallData._voipLocalView.src = "";
                    YTX_CONFIG._voipCallData._voipLocalView = null
                }
            }
            YTX_CONFIG._voipCallData._connected = false;
            YTX_CONFIG._voipCallData._callEventCallId = null;
            YTX_CONFIG._voipCallData._peerConnection = null;
            YTX_CONFIG._voipCallData._inviteSdp = null;
            YTX_CONFIG._voipCallData._localMediaStream = null
        },
        _setTelRemote: function (callEventData)
        {
            var receiverSdp = callEventData.getStrSDP();
            var pc = YTX_CONFIG._voipCallData._peerConnection;
            if (!pc)
            {
                return
            }
            var remoteError = function (err)
            {
                console.log("RemoteError" + err)
            };
            var sessionDescription = YTX_CONFIG.util.getSessionDescription();
            pc.setRemoteDescription(new sessionDescription({type: "answer", sdp: receiverSdp}), function ()
            {
            }, remoteError);
            return
        },
        _sendAck: function (callEventData)
        {
            var receiverSdp = callEventData.getStrSDP();
            var pc = YTX_CONFIG._voipCallData._peerConnection;
            if (!pc)
            {
                return
            }
            var remoteError = function (err)
            {
                console.log("RemoteError" + err)
            };
            try
            {
                if (pc.getReceivers().length > 0)
                {
                    callEventData.setCallEvent(6);
                    callEventData.setStrSDP();
                    var str = YTX_CONFIG._protobuf._buildCallEvent(callEventData, function ()
                    {
                    }, function ()
                    {
                        console.log("send ack err")
                    });
                    YTX_CONFIG._sendMsg(str);
                    YTX_CONFIG._voipCallData._connected = true;
                    return
                }
            } catch (e)
            {
                if (pc.getRemoteStreams().length > 0)
                {
                    callEventData.setCallEvent(6);
                    callEventData.setStrSDP();
                    var str = YTX_CONFIG._protobuf._buildCallEvent(callEventData, function ()
                    {
                    }, function ()
                    {
                        console.log("send ack err")
                    });
                    YTX_CONFIG._sendMsg(str);
                    YTX_CONFIG._voipCallData._connected = true;
                    return
                }
            }
            var sessionDescription = YTX_CONFIG.util.getSessionDescription();
            pc.setRemoteDescription(new sessionDescription({type: "answer", sdp: receiverSdp}), function ()
            {
            }, remoteError);
            return
        },
        _processSDP: function (strSDP)
        {
            var tabStr = '';
            if (strSDP.indexOf('\r\n') > 0)
            {
                tabStr = '\r\n'
            }
            else if (strSDP.indexOf('\r') > 0)
            {
                tabStr = '\r'
            }
            else if (strSDP.indexOf('\n') > 0)
            {
                tabStr = '\n'
            }
            var arr = strSDP.split('m=');
            var sendSDP = '';
            for (var i in arr)
            {
                var subStr = arr[i];
                if (subStr.substr(0, 2) == 'v=')
                {
                    sendSDP += subStr;
                    continue
                }
                var typeIdx = subStr.indexOf(tabStr);
                var typeHead = subStr.substr(0, typeIdx);
                var headArr = typeHead.split(' ');
                var newHead = 'm=';
                for (var j in headArr)
                {
                    if (j < 3)
                    {
                        newHead += headArr[j] + ' '
                    }
                }
                ;
                newHead = newHead.substr(0, newHead.length - 1);
                var typeBody = subStr.substr(typeIdx + tabStr.length);
                var newBody = '';
                var bodyArr = typeBody.split(tabStr);
                var delCode = '';
                var localIp = '';
                for (var j in bodyArr)
                {
                    if (bodyArr[j].indexOf('candidate') > 0)
                    {
                        var candiArry = bodyArr[j].split(' ');
                        if (candiArry[4].indexOf('.') > -1 && localIp.length == 0)
                        {
                            localIp = candiArry[4];
                            break
                        }
                    }
                }
                for (var j in bodyArr)
                {
                    if (bodyArr[j].indexOf('rtpmap') > 0)
                    {
                        var eIdx = bodyArr[j].indexOf(' ');
                        var sIdx = bodyArr[j].indexOf(':');
                        var code = bodyArr[j].substring(sIdx + 1, eIdx);
                        if (bodyArr[j].indexOf('PCMA') > 0 || bodyArr[j].indexOf('ISAC') > 0 || bodyArr[j].indexOf('G722') > 0 || bodyArr[j].indexOf('rtx') > 0)
                        {
                            delCode = code;
                            continue
                        }
                        newHead += ' ' + code;
                        newBody += tabStr + bodyArr[j]
                    }
                    else if (bodyArr[j].indexOf('fmtp') > 0)
                    {
                        if (bodyArr[j].indexOf('a=fmtp:' + delCode + ' ') < 0)
                        {
                            newBody += tabStr + bodyArr[j]
                        }
                    }
                    else if (bodyArr[j].indexOf('candidate') > 0)
                    {
                        if (bodyArr[j].indexOf('.') > 0)
                        {
                            newBody += tabStr + bodyArr[j]
                        }
                        else
                        {
                            continue
                        }
                    }
                    else if (bodyArr[j].indexOf('c=') == 0)
                    {
                        newBody += localIp.length > 0 ? (tabStr + "c=IN IP4 " + localIp) : (tabStr + bodyArr[j])
                    }
                    else
                    {
                        newBody += tabStr + bodyArr[j]
                    }
                }
                sendSDP += newHead + newBody
            }
            return sendSDP
        },
        _cLength: function (str)
        {
            var reg = /([0-9a-f]{1,4}:)|(:[0-9a-f]{1,4})/gi;
            var temp = str.replace(reg, ' ');
            return temp.length
        },
        _isIPv6: function (tmpstr)
        {
            var patrn = /([0-9a-f]{1,4}:){7}[0-9a-f]{1,4}/i;
            var r = patrn.exec(tmpstr);
            if (r)
            {
                return true
            }
            if (tmpstr == "::")
            {
                return true
            }
            patrn = /(([0-9a-f]{1,4}:){0,6})((:[0-9a-f]{1,4}){0,6})/i;
            r = patrn.exec(tmpstr);
            if (r)
            {
                var c = YTX_CONFIG._cLength(tmpstr);
                if (c <= 7 && c > 0)
                {
                    return true
                }
            }
            patrn = /([0-9a-f]{1,4}:){1,7}:/i;
            r = patrn.exec(tmpstr);
            if (r)
            {
                return true
            }
            patrn = /:(:[0-9a-f]{1,4}){1,7}/i;
            r = patrn.exec(tmpstr);
            if (r)
            {
                return true
            }
            patrn = /([0-9a-f]{1,4}:){6}(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})/i;
            r = patrn.exec(tmpstr);
            if (r)
            {
                if (r[2] <= 255 && r[3] <= 255 && r[4] <= 255 && r[5] <= 255)
                {
                    return true
                }
            }
            patrn = /([0-9a-f]{1,4}:){1,5}:(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})/i;
            r = patrn.exec(tmpstr);
            if (r)
            {
                if (r[2] <= 255 && r[3] <= 255 && r[4] <= 255 && r[5] <= 255)
                {
                    return true
                }
            }
            patrn = /::(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})/i;
            r = patrn.exec(tmpstr);
            if (r)
            {
                if (r[1] <= 255 && r[2] <= 255 && r[3] <= 255 && r[4] <= 255)
                {
                    return true
                }
            }
            return false
        },
        _sendVoip: function (CallEventBuilder, callback, onError)
        {
            var iceServer = {"iceServers": YTX_CONFIG._voipCallData._iceServers};
            var isCaller = false;
            var onIceCompleted = false;
            var isVideo = null;
            if (CallEventBuilder.getCallEvent() == 1)
            {
                if (1 == CallEventBuilder.getIsVoipCall())
                {
                    isVideo = true
                }
                else
                {
                    isVideo = false
                }
            }
            else
            {
                if (1 == YTX_CONFIG._voipCallData._voipCallType)
                {
                    isVideo = true
                }
                else
                {
                    isVideo = false
                }
            }
            if (YTX_CONFIG._userName == CallEventBuilder.getCaller())
            {
                isCaller = true
            }
            var peerConnection = YTX_CONFIG.util.getPeerConnection();
            if (!peerConnection)
            {
                var resp = {};
                resp.code = YTX_CONFIG._errcode._NOT_SUPPORT_CALL;
                resp.msg = 'browers not support call operation';
                onError(resp)
            }
            var options = {optional: [{DtlsSrtpKeyAgreement: true}]};
            var pc = new peerConnection(iceServer, options);
            YTX_CONFIG._voipCallData._peerConnection = pc;
            if (!YTX_CONFIG._voipCallData._voipOtherView)
            {
                if (CallEventBuilder.getIsVoipCall() == 0 || CallEventBuilder.getIsVoipCall() == 2)
                {
                    YTX_CONFIG._voipCallData._voipOtherView = document.createElement("video")
                }
                else
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._VOIP_NO_VIDEO;
                    resp.msg = 'please set view first.';
                    onError(resp);
                    return
                }
            }
            ;
            pc.onicecandidate = function (event)
            {
                console.log("+++ onicecandidate +++");
                if (event.candidate)
                {
                    console.log("+++ onicecandidate:" + event.candidate.candidate)
                }
                else
                {
                    onIceCompleted = true;
                    console.log("+++ onicecandidate end! +++")
                }
            };
            function addStream(event)
            {
                var windowUrl = YTX_CONFIG.util.getWindowURL();
                if (YTX_CONFIG._voipCallData._voipOtherView.srcObject == undefined)
                {
                    YTX_CONFIG._voipCallData._voipOtherView.src = windowUrl.createObjectURL(event.streams ? event.streams[0] : event.stream)
                }
                else
                {
                    YTX_CONFIG._voipCallData._voipOtherView.srcObject = event.streams ? event.streams[0] : event.stream
                }
            }

            if ('ontrack' in pc)
            {
                pc.ontrack = addStream
            }
            else if ('onaddtrack' in pc)
            {
                pc.onaddtrack = addStream
            }
            else if ('onaddstream' in pc)
            {
                pc.onaddstream = addStream
            }
            function sendOfferAndAnswer(stream)
            {
                var sendOfferFn = function (desc)
                {
                    var count = 0;

                    function sendOffer()
                    {
                        count++;
                        if (pc.iceGatheringState == "complete" || count > 10)
                        {
                            console.log("+++ sendOffer " + count);
                            var strSDP = pc.localDescription.sdp;
                            var preSDP = YTX_CONFIG._processSDP(strSDP);
                            CallEventBuilder.setStrSDP(preSDP);
                            var state = 2;
                            if (CallEventBuilder.getCallId() == YTX_CONFIG._voipCallData._callEventCallId)
                            {
                                var sendStr = YTX_CONFIG._protobuf._buildCallEvent(CallEventBuilder, callback, onError);
                                if (!!sendStr)
                                {
                                    YTX_CONFIG._sendMsg(sendStr)
                                }
                            }
                            else
                            {
                                state = 4
                            }
                            var resp = {};
                            resp.callId = CallEventBuilder.getCallId();
                            resp.caller = CallEventBuilder.getCaller();
                            resp.called = CallEventBuilder.getCalled();
                            resp.userdata = CallEventBuilder.getUserData();
                            resp.state = state;
                            YTX_CONFIG._voipCallData._voipCallType = CallEventBuilder.getIsVoipCall();
                            resp.callType = CallEventBuilder.getIsVoipCall();
                            resp.code = 200;
                            YTX_CONFIG._voipListener(resp)
                        }
                        else
                        {
                            window.setTimeout(function ()
                            {
                                sendOffer()
                            }, 200)
                        }
                    };
                    desc.sdp = YTX_CONFIG._processSDP(desc.sdp);
                    pc.setLocalDescription(desc, function ()
                    {
                        console.log("+++ sendOffer setLocalDescription succ");
                        sendOffer()
                    }, function (str)
                    {
                        console.log("+++ sendOffer setLocalDescription failed")
                    })
                };
                var sendAnswerFn = function (desc)
                {
                    var count = 0;

                    function sendAnswer()
                    {
                        count++;
                        if (pc.iceGatheringState == "complete" || count > 10)
                        {
                            console.log("+++ sendAnswer " + count);
                            var strSDP = pc.localDescription.sdp;
                            var preSDP = YTX_CONFIG._processSDP(strSDP);
                            CallEventBuilder.setStrSDP(preSDP);
                            if (CallEventBuilder.getCallId() == YTX_CONFIG._voipCallData._callEventCallId)
                            {
                                var sendStr = YTX_CONFIG._protobuf._buildCallEvent(CallEventBuilder, callback, onError);
                                if (!!sendStr)
                                {
                                    YTX_CONFIG._sendMsg(sendStr)
                                }
                                YTX_CONFIG._voipCallData._connected = true;
                                var resp = new Object();
                                resp.code = "200";
                                callback(resp)
                            }
                        }
                        else
                        {
                            window.setTimeout(function ()
                            {
                                sendAnswer()
                            }, 200)
                        }
                    };
                    desc.sdp = YTX_CONFIG._processSDP(desc.sdp);
                    pc.setLocalDescription(desc, function ()
                    {
                        console.log("+++ sendAnswer setLocalDescription succ");
                        sendAnswer()
                    }, function (e)
                    {
                        console.log("+++ sendAnswer setLocalDescription failed")
                    })
                };
                var error = function (err)
                {
                    console.log("createOfferORAnswer Failed!")
                };
                var remoteError = function (err)
                {
                    console.log("RemoteError" + err)
                };
                var windowUrl = YTX_CONFIG.util.getWindowURL();
                if (!!YTX_CONFIG._voipCallData._voipLocalView && !!windowUrl)
                {
                    if (YTX_CONFIG._voipCallData._voipLocalView.srcObject == undefined)
                    {
                        YTX_CONFIG._voipCallData._voipLocalView.src = windowUrl.createObjectURL(stream)
                    }
                    else
                    {
                        YTX_CONFIG._voipCallData._voipLocalView.srcObject = stream
                    }
                }
                ;
                YTX_CONFIG._voipCallData._localMediaStream = stream;
                try
                {
                    stream.getTracks().forEach(function (track)
                    {
                        pc.addTrack(track, stream)
                    });
                    console.log("+++ addTrack succ!")
                } catch (e)
                {
                    pc.addStream(stream);
                    console.log("+++ addStream succ!")
                }
                var constraints = {mandatory: {OfferToReceiveAudio: true, OfferToReceiveVideo: isVideo}};
                if (isCaller)
                {
                    pc.createOffer(sendOfferFn, error)
                }
                else
                {
                    var sessionDescription = YTX_CONFIG.util.getSessionDescription();
                    var inviteSdp = YTX_CONFIG._voipCallData._inviteSdp;
                    var mb = YTX_CONFIG._browser();
                    pc.setRemoteDescription(new sessionDescription({type: "offer", sdp: inviteSdp}), function ()
                    {
                        pc.createAnswer(sendAnswerFn, error, constraints)
                    }, remoteError)
                }
            }

            try
            {
                navigator.mediaDevices.getUserMedia({audio: true, video: isVideo}).then(function (stream)
                {
                    sendOfferAndAnswer(stream)
                }).catch(function (err)
                {
                    console.log(err.name);
                    console.log("出错啦  getusermedia")
                })
            } catch (e)
            {
                var getUserMedia = YTX_CONFIG.util.getUserMedia();
                if (getUserMedia)
                {
                    getUserMedia.call(navigator, {"audio": true, "video": isVideo}, sendOfferAndAnswer, function (error)
                    {
                        pc.close();
                        var resp = {};
                        resp.code = YTX_CONFIG._errcode._VOIP_MEDIA_ERROR;
                        resp.msg = 'get media stream error.';
                        onError(resp)
                    })
                }
                else
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._VOIP_NO_MEDIA;
                    resp.code = 'borwer not support getUserMedia.';
                    onError(resp)
                }
            }
        },
        _checkASCII: function (content)
        {
            var regx = /^[\x00-\\x7F\a-zA-Z\u4e00-\u9fa5、]+$/;
            if (regx.exec(content) == null)
            {
                return false
            }
            return true
        },
        _checkCHAR: function (content)
        {
            var regx = /^[a-zA-Z\u4e00-\u9fa5]+$/;
            if (regx.exec(content) == null)
            {
                return false
            }
            return true
        },
        _uploadUserDevice: function (callback, onError)
        {
            if (!YTX_CONFIG._checkOnline(onError, null))
            {
                return null
            }
            var sig = YTX_CONFIG._fileSig;
            var sendJsonStr = '{\"1\":\"' + YTX_CONFIG._appid + '\",\"2\":\"' + YTX_CONFIG._userName + '\",';
            sendJsonStr += '\"3\":\"' + YTX_CONFIG._deviceType + '\"';
            var ua = window.navigator.userAgent;
            if (!!ua)
            {
                sendJsonStr += ',\"4\":\"' + ua + '\"'
            }
            var sendFunc = function ()
            {
                sendJsonStr += ',\"11\":\"' + YTX_CONFIG._version + '\",\"12\":\"' + YTX_CONFIG._imei + '\"';
                var sendProto = '{\"UserDevice\":' + sendJsonStr + '}';
                var clientNo = YTX_CONFIG._generateClientNo(callback, onError);
                var sig = '';
                var sendStr = '{\"Http\":{\"1\":4,\"2\":' + sendProto + ',\"3\":' + clientNo + ',\"4\":\"' + sig + '\"}}';
                YTX_CONFIG._sendMsg(sendStr)
            };
            if (window.navigator.geolocation)
            {
                var options = {enableHighAccuracy: true, timeout: 1000};
                window.navigator.geolocation.getCurrentPosition(function (pos)
                {
                    var coords = pos.coords;
                    var latitude = coords.latitude * 1000;
                    var longitude = coords.longitude * 1000;
                    sendJsonStr += ',\"9\":\"' + latitude + '\",\"10\":\"' + longitude + '\"';
                    sendFunc()
                }, sendFunc, options)
            }
            else
            {
                sendFunc()
            }
        },
        _releaseResource: function ()
        {
            if (YTX_CONFIG._voipCallData._peerConnection != null)
            {
                if (YTX_CONFIG._voipCallData._peerConnection.signalingState != "closed")
                {
                    YTX_CONFIG._voipCallData._peerConnection.close();
                    YTX_CONFIG._voipCallData._peerConnection = null
                }
                YTX_CONFIG._voipCallData._voipOtherView.srcObject = null;
                YTX_CONFIG._voipCallData._voipOtherView.src = "";
                YTX_CONFIG._voipCallData._voipOtherView = null;
                if (YTX_CONFIG._voipCallData._voipLocalView)
                {
                    YTX_CONFIG._voipCallData._voipLocalView.srcObject = null;
                    YTX_CONFIG._voipCallData._voipLocalView.src = "";
                    YTX_CONFIG._voipCallData._voipLocalView = null
                }
            }
            YTX_CONFIG._voipCallData._connected = false;
            YTX_CONFIG._voipCallData._callEventCallId = null;
            YTX_CONFIG._voipCallData._peerConnection = null;
            YTX_CONFIG._voipCallData._inviteSdp = null;
            YTX_CONFIG._voipCallData._localMediaStream = null;
            YTX_CONFIG._voipCallData._calltype = null
        },
        _getFileSig: function (num)
        {
            if (!num)
            {
                num = 1
            }
            else
            {
                num++
            }
            if (num > 3)
            {
                return
            }
            var url = Base64.decode(YTX_CONFIG._file_sig_url);
            $.ajax({
                url: url, dataType: 'jsonp', jsonp: 'cb', success: function (result)
                {
                    if (result.code == 000000)
                    {
                        YTX_CONFIG._fileSig = result.data
                    }
                    else
                    {
                        YTX_CONFIG._getFileSig(num)
                    }
                }, error: function ()
                {
                    YTX_CONFIG._getFileSig(num)
                }
            })
        },
        util: {
            checkFileReader: function ()
            {
                var FileReader = FileReader || window.FileReader;
                if (!FileReader)
                {
                    return false
                }
                return true
            }, getWindowURL: function ()
            {
                var url = window.URL || window.webkitURL || window.mozURL || window.msURL;
                return url
            }, getUserMedia: function ()
            {
                var getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia;
                if (!!navigator.mediaDevices && !!navigator.mediaDevices.getUserMedia)
                {
                    getUserMedia = navigator.mediaDevices.getUserMedia
                }
                else if (typeof navigator !== 'undefined' && navigator.webkitGetUserMedia)
                {
                    getUserMedia = navigator.webkitGetUserMedia.bind(navigator)
                }
                else if (typeof navigator !== 'undefined' && navigator.mozGetUserMedia)
                {
                    getUserMedia = navigator.mozGetUserMedia.bind(navigator)
                }
                else if (typeof navigator !== 'undefined' && navigator.getUserMedia)
                {
                    getUserMedia = navigator.getUserMedia.bind(navigator)
                }
                return getUserMedia
            }, getPeerConnection: function ()
            {
                var peerConnection = window.RTCPeerConnection || window.mozRTCPeerConnection || window.webkitRTCPeerConnection || window.msRTCPeerConnection;
                if (typeof RTCPeerConnection !== 'undefined')
                {
                    peerConnection = RTCPeerConnection
                }
                else if (typeof mozRTCPeerConnection !== 'undefined')
                {
                    peerConnection = mozRTCPeerConnection
                }
                else if (typeof webkitRTCPeerConnection !== 'undefined')
                {
                    peerConnection = webkitRTCPeerConnection
                }
                return peerConnection
            }, getSessionDescription: function ()
            {
                var sessionDescription = window.RTCSessionDescription || window.mozRTCSessionDescription || window.webkitRTCSessionDescription || window.msRTCSessionDescription;
                if (typeof RTCSessionDescription !== 'undefined')
                {
                    sessionDescription = RTCSessionDescription
                }
                else if (typeof mozRTCSessionDescription !== 'undefined')
                {
                    sessionDescription = mozRTCSessionDescription
                }
                else if (typeof webkitRTCSessionDescription !== 'undefined')
                {
                    sessionDescription = webkitRTCSessionDescription
                }
                return sessionDescription
            }, getBrowerPrefix: function ()
            {
                return 'hidden' in document ? null : function ()
                    {
                        var r = null;
                        ['webkit', 'moz', 'ms', 'o'].forEach(function (prefix)
                        {
                            if ((prefix + 'Hidden') in document)
                            {
                                return r = prefix
                            }
                        });
                        return r
                    }()
            }, checkWindowHidden: function ()
            {
                var prefix = YTX_CONFIG.util.getBrowerPrefix();
                if (!prefix)
                {
                    return document['hidden']
                }
                return document[prefix + 'Hidden']
            }, getWindowVisibleState: function ()
            {
                var prefix = YTX_CONFIG.util.getBrowerPrefix();
                if (!prefix)
                {
                    return document['visibilityState']
                }
                return document[prefix + 'VisibilityState']
            }, stopMediaStream: function (stream)
            {
                if (stream.getTracks())
                {
                    console.log("stream.getTracks()");
                    for (var track in stream.getTracks())
                    {
                        stream.getTracks()[track].stop()
                    }
                }
                else
                {
                    stream.stop()
                }
            }
        },
        _browser: function ()
        {
            var userAgent = navigator.userAgent;
            var isOpera = userAgent.indexOf("Opera") > -1;
            if (isOpera)
            {
                return "Opera"
            }
            ;
            if (userAgent.indexOf("Firefox") > -1)
            {
                return "FF"
            }
            if (userAgent.indexOf("Chrome") > -1)
            {
                return "Chrome"
            }
            if (userAgent.indexOf("Safari") > -1)
            {
                return "Safari"
            }
            if (userAgent.indexOf("compatible") > -1 && userAgent.indexOf("MSIE") > -1 && !isOpera)
            {
                return "IE"
            }
        }
    };
    window.RL_YTX = window.RL_YTX || {
            _msgType: {
                _TEXT: 1,
                _VOICE: 2,
                _VEDIO: 3,
                _PICTURE: 4,
                _POSITION: 5,
                _COMPRESS_FILE: 6,
                _FILE: 7,
                _sendAtMsg: 11,
                _userMsgState: 12
            },
            init: function (appid, serverIp, lvsServer, fileSig)
            {
                var resp = {};
                if (!RL_YTX.checkH5())
                {
                    resp.code = YTX_CONFIG._errcode._NOT_SUPPORT_H5;
                    resp.msg = 'The brower do not support HTML5,please change the brower';
                    return resp
                }
                if (!appid)
                {
                    resp.code = YTX_CONFIG._errcode._NO_REQUIRED_PARAM;
                    resp.msg = 'appid  is null,please check you param';
                    return resp
                }
                if (!!serverIp)
                {
                    YTX_CONFIG._server_ip[0] = Base64.encode(serverIp);
                    YTX_CONFIG._file_server_url = Base64.encode(serverIp)
                }
                if (!!lvsServer)
                {
                    YTX_CONFIG._lvs_servers[0] = Base64.encode(lvsServer)
                }
                var notSupport = [];
                if (!YTX_CONFIG.util.getUserMedia())
                {
                    notSupport.push(YTX_CONFIG._errcode._VOIP_NO_MEDIA)
                }
                if (!YTX_CONFIG.util.checkFileReader())
                {
                    notSupport.push(YTX_CONFIG._errcode._NOT_SUPPORT_FILE)
                }
                if (!YTX_CONFIG.util.getPeerConnection())
                {
                    notSupport.push(YTX_CONFIG._errcode._NOT_SUPPORT_CALL)
                }
                if (!YTX_CONFIG.util.getWindowURL())
                {
                    notSupport.push(YTX_CONFIG._errcode._NOT_SUPPORT_URL)
                }
                YTX_CONFIG._Notification = window.Notification || window.mozNotification || window.webkitNotification || window.msNotification || window.webkitNotifications;
                if (!!YTX_CONFIG._Notification)
                {
                    YTX_CONFIG._Notification.requestPermission(function (permission)
                    {
                        if (YTX_CONFIG._Notification.permission !== "granted")
                        {
                            YTX_CONFIG._Notification.permission = "granted"
                        }
                    })
                }
                YTX_CONFIG._fileSig = fileSig;
                YTX_CONFIG._appid = appid;
                resp.code = YTX_CONFIG._errcode._SUCC;
                resp.msg = 'init success';
                resp.unsupport = notSupport;
                return resp
            },
            onDeskMsgReceiveListener: function (callback)
            {
            },
            destory: function ()
            {
                if (!!YTX_CONFIG._socket)
                {
                    YTX_CONFIG._socket.close()
                }
            },
            checkH5: function ()
            {
                if (!!window.applicationCache && !!window.WebSocket)
                {
                    YTX_CONFIG._log(YTX_CONFIG._logLev._INFO, "this brower is support H5");
                    return true
                }
                else
                {
                    YTX_CONFIG._log(YTX_CONFIG._logLev._ERROR, "sorry, your brower not support H5, exist!");
                    return false
                }
            },
            login: function (LoginBuilder, callback, onError)
            {
                if (YTX_CONFIG._loginStatus != 1)
                {
                    if (YTX_CONFIG._loginStatus == 3)
                    {
                        YTX_CONFIG._log(YTX_CONFIG._logLev._INFO, "user already login.")
                    }
                    else if (YTX_CONFIG._loginStatus == 2)
                    {
                        YTX_CONFIG._log(YTX_CONFIG._logLev._INFO, "user logining")
                    }
                    return
                }
                if (!YTX_CONFIG._fileSig)
                {
                    YTX_CONFIG._fileSig = '2b9c64616c98a93f1375bf0a2f6429e7'
                }
                YTX_CONFIG._userName = LoginBuilder.getUserName();
                YTX_CONFIG._userPwd = LoginBuilder.getPwd();
                YTX_CONFIG._getServerIp(LoginBuilder.getType(), callback, onError, LoginBuilder.getSig(), LoginBuilder.getTimestamp(), true)
            },
            logout: function (callback, onError)
            {
                YTX_CONFIG._confirmMsg();
                if (!!YTX_CONFIG._voipCallData._callEventCallId)
                {
                    var releaseCallBuilder = new RL_YTX.ReleaseCallBuilder();
                    releaseCallBuilder.setCallId(YTX_CONFIG._voipCallData._callEventCallId);
                    releaseCallBuilder.setCaller(YTX_CONFIG._voipCallData._caller);
                    releaseCallBuilder.setCalled(YTX_CONFIG._voipCallData._called);
                    RL_YTX.releaseCall(releaseCallBuilder, function (sucObj)
                    {
                    }, function (errObj)
                    {
                    })
                }
                ;
                var logoutStr = YTX_CONFIG._protobuf._buildLogout(callback, onError);
                if (!!logoutStr)
                {
                    YTX_CONFIG._sendMsg(logoutStr)
                }
                ;
                YTX_CONFIG._logout();
                callback()
            },
            bindBeforeUnLoad: function (callback)
            {
                if (!!YTX_CONFIG._beforeUnLoad)
                {
                    YTX_CONFIG._beforeUnLoad[YTX_CONFIG._beforeUnLoad.length] = callback
                }
                return YTX_CONFIG._beforeUnLoad.length - 1
            },
            unbindBeforeUnLoad: function (i)
            {
                YTX_CONFIG._beforeUnLoad[i] = null
            },
            sendMsg: function (MsgBuilder, callback, onError, progress)
            {
                var isAvailable = false;
                for (var i in RL_YTX._msgType)
                {
                    if (MsgBuilder.getType() == RL_YTX._msgType[i])
                    {
                        isAvailable = true;
                        break
                    }
                }
                if (!isAvailable)
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._CHARSET_ILLEGAl;
                    resp.msg = "msgType isn't the value of available";
                    onError(resp)
                }
                else
                {
                    var msgToken = null;
                    if (MsgBuilder.getType() != 1 && !!MsgBuilder.getFile())
                    {
                        var FileReader = FileReader || window.FileReader;
                        if (!FileReader)
                        {
                            var resp = {};
                            resp.code = YTX_CONFIG._errcode._NOT_SUPPORT_FILE;
                            resp.msgId = -1;
                            resp.msgClientNo = -1;
                            resp.msg = 'brower not support send attach.';
                            onError(resp);
                            return -1
                        }
                        msgToken = YTX_CONFIG._generateFullMsgId(++YTX_CONFIG._ClientNo);
                        YTX_CONFIG._sendFile(MsgBuilder.getFile(), null, MsgBuilder.getReceiver(), MsgBuilder.getType(), msgToken, MsgBuilder.getDomain(), 1, callback, onError, progress, MsgBuilder.getFileName())
                    }
                    else
                    {
                        msgToken = ++YTX_CONFIG._ClientNo;
                        var sendStr = YTX_CONFIG._protobuf._buildSendTextMsg(MsgBuilder.getType(), MsgBuilder.getText(), MsgBuilder.getReceiver(), msgToken, MsgBuilder.getDomain(), callback, onError, MsgBuilder.getId(), MsgBuilder.getAtAccounts());
                        if (!!sendStr)
                        {
                            YTX_CONFIG._sendMsg(sendStr)
                        }
                        msgToken = YTX_CONFIG._generateFullMsgId(msgToken)
                    }
                    return msgToken
                }
            },
            mcmUserStartAsk: function (osUnityAccount, agentId, addrJson, callback, onError)
            {
                var sendStr = YTX_CONFIG._protobuf._buildMCM_UserEvt_StartAsk(osUnityAccount, agentId, null, addrJson, callback, onError);
                if (!!sendStr)
                {
                    YTX_CONFIG._sendMsg(sendStr)
                }
            },
            mcmUserEndAsk: function (osUnityAccount, callback, onError)
            {
                var sendStr = YTX_CONFIG._protobuf._buildMCM_UserEvt_EndAsk(osUnityAccount, null, callback, onError);
                if (!!sendStr)
                {
                    YTX_CONFIG._sendMsg(sendStr)
                }
            },
            mcmUserSendMsg: function (MCMMessageBuilder, callback, onError, progress)
            {
                var msgId = null;
                if (MCMMessageBuilder.getMsgType() != 1 && !!MCMMessageBuilder.getFile())
                {
                    msgId = YTX_CONFIG._generateFullMsgId(++YTX_CONFIG._ClientNo);
                    YTX_CONFIG._sendFile(MCMMessageBuilder.getFile(), null, MCMMessageBuilder.getAccount(), MCMMessageBuilder.getMsgType(), msgId, MCMMessageBuilder.getUserData(), 2, callback, onError, progress, MCMMessageBuilder.getFileName(), MCMMessageBuilder.getMsgId())
                }
                else
                {
                    msgId = ++YTX_CONFIG._ClientNo;
                    var sendStr = YTX_CONFIG._protobuf._buildMCM_UserEvt_SendMSG(MCMMessageBuilder.getAccount(), MCMMessageBuilder.getContent(), MCMMessageBuilder.getUserData(), MCMMessageBuilder.getMsgType(), msgId, callback, onError, MCMMessageBuilder.getMsgId());
                    if (!!sendStr)
                    {
                        YTX_CONFIG._sendMsg(sendStr)
                    }
                    msgId = YTX_CONFIG._generateFullMsgId(msgId)
                }
                return msgId
            },
            mcmAgentSendMsg: function (MCMMessageBuilder, callback, onError, progress)
            {
                var msgId = null;
                if (MCMMessageBuilder.getMsgType() != 1 && !!MCMMessageBuilder.getFile())
                {
                    msgId = YTX_CONFIG._generateFullMsgId(++YTX_CONFIG._ClientNo);
                    YTX_CONFIG._sendFile(MCMMessageBuilder.getFile(), null, MCMMessageBuilder.getAccount(), MCMMessageBuilder.getMsgType(), msgId, MCMMessageBuilder.getUserData(), 3, callback, onError, progress, MCMMessageBuilder.getFileName(), MCMMessageBuilder.getMsgId())
                }
                else
                {
                    msgId = ++YTX_CONFIG._ClientNo;
                    var sendStr = YTX_CONFIG._protobuf._buildMCM_AgentEvt_SendMCM(MCMMessageBuilder.getAccount(), MCMMessageBuilder.getContent(), MCMMessageBuilder.getUserData(), MCMMessageBuilder.getMsgType(), msgId, callback, onError, MCMMessageBuilder.getMsgId(), MCMMessageBuilder.getChanType(), MCMMessageBuilder.getMailTitle());
                    if (!!sendStr)
                    {
                        YTX_CONFIG._sendMsg(sendStr)
                    }
                    msgId = YTX_CONFIG._generateFullMsgId(msgId)
                }
                return msgId
            },
            mcmAgentStartSerWithUser: function (userAccount, MCMDataBuilder, agentId, callback, onError)
            {
                var sendStr = YTX_CONFIG._protobuf._buildMCM_AgentEvt_StartSerWithUser(userAccount, MCMDataBuilder, agentId, callback, onError);
                if (!!sendStr)
                {
                    YTX_CONFIG._sendMsg(sendStr)
                }
            },
            mcmAgentStopSerWithUser: function (userAccount, callback, onError)
            {
                var sendStr = YTX_CONFIG._protobuf._buildMCM_AgentEvt_StopSerWithUser(userAccount, callback, onError);
                if (!!sendStr)
                {
                    YTX_CONFIG._sendMsg(sendStr)
                }
            },
            mcmAgentKFOnWork: function (serverCap, MCMAgentInfoBuilder, callback, onError)
            {
                var sendStr = YTX_CONFIG._protobuf._buildMCM_AgentEvt_KFOnWork(serverCap, MCMAgentInfoBuilder, callback, onError);
                if (!!sendStr)
                {
                    YTX_CONFIG._sendMsg(sendStr)
                }
            },
            mcmAgentKFOffWork: function (agentId, callback, onError)
            {
                var sendStr = YTX_CONFIG._protobuf._buildMCM_AgentEvt_KFOffWork(agentId, callback, onError);
                if (!!sendStr)
                {
                    YTX_CONFIG._sendMsg(sendStr)
                }
            },
            mcmAgentReady: function (agentId, callback, onError)
            {
                var sendStr = YTX_CONFIG._protobuf._buildMCM_AgentEvt_Ready(agentId, callback, onError);
                if (!!sendStr)
                {
                    YTX_CONFIG._sendMsg(sendStr)
                }
            },
            mcmAgentNotReady: function (agentId, callback, onError)
            {
                var sendStr = YTX_CONFIG._protobuf._buildMCM_AgentEvt_NotReady(agentId, callback, onError);
                if (!!sendStr)
                {
                    YTX_CONFIG._sendMsg(sendStr)
                }
            },
            mcmAgentRejectUser: function (userAccount, ccpCustomData, agentId, callback, onError)
            {
                var sendStr = YTX_CONFIG._protobuf._buildMCM_AgentEvt_RejectUser(userAccount, ccpCustomData, agentId, callback, onError);
                if (!!sendStr)
                {
                    YTX_CONFIG._sendMsg(sendStr)
                }
            },
            mcmAgentTransKF: function (userAccount, osUnityAccount, transAgentId, agentId, callback, onError)
            {
                var sendStr = YTX_CONFIG._protobuf._buildMCM_AgentEvt_TransKF(userAccount, osUnityAccount, transAgentId, agentId, callback, onError);
                if (!!sendStr)
                {
                    YTX_CONFIG._sendMsg(sendStr)
                }
            },
            mcmAgentTransferQueue: function (userAccount, queueType, callback, onError)
            {
                var sendStr = YTX_CONFIG._protobuf._buildMCM_AgentEvt_TransferQueue(userAccount, queueType, callback, onError);
                if (!!sendStr)
                {
                    YTX_CONFIG._sendMsg(sendStr)
                }
            },
            mcmAgentMonitorAgent: function (userAccount, agentId, callback, onError)
            {
                var sendStr = YTX_CONFIG._protobuf._buildMCM_AgentEvt_MonitorAgent(userAccount, agentId, callback, onError);
                if (!!sendStr)
                {
                    YTX_CONFIG._sendMsg(sendStr)
                }
            },
            mcmAgentCancelMonitorAgent: function (userAccount, agentId, callback, onError)
            {
                var sendStr = YTX_CONFIG._protobuf._buildMCM_AgentEvt_CancelMonitorAgent(userAccount, agentId, callback, onError);
                if (!!sendStr)
                {
                    YTX_CONFIG._sendMsg(sendStr)
                }
            },
            mcmAgentForceTransfer: function (userAccount, superAgentId, agentId, transAgentId, callback, onError)
            {
                var sendStr = YTX_CONFIG._protobuf._buildMCM_AgentEvt_ForceTransfer(userAccount, superAgentId, agentId, transAgentId, callback, onError);
                if (!!sendStr)
                {
                    YTX_CONFIG._sendMsg(sendStr)
                }
            },
            mcmAgentForceEndService: function (userAccount, superAgentId, agentId, callback, onError)
            {
                var sendStr = YTX_CONFIG._protobuf._buildMCM_AgentEvt_ForceEndService(userAccount, superAgentId, agentId, callback, onError);
                if (!!sendStr)
                {
                    YTX_CONFIG._sendMsg(sendStr)
                }
            },
            mcmAgentQueryQueueInfo: function (queueType, callback, onError)
            {
                var sendStr = YTX_CONFIG._protobuf._buildMCM_AgentEvt_QueryQueueInfo(queueType, callback, onError);
                if (!!sendStr)
                {
                    YTX_CONFIG._sendMsg(sendStr)
                }
            },
            mcmAgentQueryAgentInfo: function (agentId, callback, onError)
            {
                var sendStr = YTX_CONFIG._protobuf._buildMCM_AgentEvt_QueryAgentInfo(agentId, callback, onError);
                if (!!sendStr)
                {
                    YTX_CONFIG._sendMsg(sendStr)
                }
            },
            mcmAgentStartConf: function (userAccount, agentId, callback, onError)
            {
                var sendStr = YTX_CONFIG._protobuf._buildMCM_AgentEvt_StartConf(userAccount, agentId, callback, onError);
                if (!!sendStr)
                {
                    YTX_CONFIG._sendMsg(sendStr)
                }
            },
            mcmAgentJoinConf: function (userAccount, agentId, callback, onError)
            {
                var sendStr = YTX_CONFIG._protobuf._buildMCM_AgentEvt_JoinConf(userAccount, agentId, callback, onError);
                if (!!sendStr)
                {
                    YTX_CONFIG._sendMsg(sendStr)
                }
            },
            mcmAgentExitConf: function (userAccount, agentId, callback, onError)
            {
                var sendStr = YTX_CONFIG._protobuf._buildMCM_AgentEvt_ExitConf(userAccount, agentId, callback, onError);
                if (!!sendStr)
                {
                    YTX_CONFIG._sendMsg(sendStr)
                }
            },
            mcmAgentStartSessionTimer: function (userAccount, callback, onError)
            {
                var sendStr = YTX_CONFIG._protobuf._buildMCM_AgentEvt_StartSessionTimer(userAccount, callback, onError);
                if (!!sendStr)
                {
                    YTX_CONFIG._sendMsg(sendStr)
                }
            },
            mcmAgentForceJoinConf: function (userAccount, agentId, callback, onError)
            {
                var sendStr = YTX_CONFIG._protobuf._buildMCM_AgentEvt_ForceJoinConf(userAccount, agentId, callback, onError);
                if (!!sendStr)
                {
                    YTX_CONFIG._sendMsg(sendStr)
                }
            },
            mcmAgentReservedForUser: function (keyType, reservedKey, agentId, callback, onError)
            {
                var sendStr = YTX_CONFIG._protobuf._buildMCM_AgentEvt_ReservedForUser(keyType, reservedKey, agentId, callback, onError);
                if (!!sendStr)
                {
                    YTX_CONFIG._sendMsg(sendStr)
                }
            },
            mcmAgentCancelReserved: function (keyType, reservedKey, agentId, callback, onError)
            {
                var sendStr = YTX_CONFIG._protobuf._buildMCM_AgentEvt_CancelReserved(keyType, reservedKey, agentId, callback, onError);
                if (!!sendStr)
                {
                    YTX_CONFIG._sendMsg(sendStr)
                }
            },
            mcmAgentSerWithTheUser: function (osUnityAccount, userAccount, chanType, agentId, callback, onError)
            {
                var sendStr = YTX_CONFIG._protobuf._buildMCM_AgentEvt_SerWithTheUser(osUnityAccount, userAccount, chanType, agentId, callback, onError);
                if (!!sendStr)
                {
                    YTX_CONFIG._sendMsg(sendStr)
                }
            },
            syncMsg: function (SyncMsgBuilder, onError)
            {
                var startVersion = SyncMsgBuilder.getSVersion();
                var endVersion = SyncMsgBuilder.getEVersion();
                var sendStr = YTX_CONFIG._protobuf._buildSyncMessage(startVersion, endVersion, SyncMsgBuilder.getType(), onError);
                if (!!sendStr)
                {
                    YTX_CONFIG._sendMsg(sendStr)
                }
            },
            getNickNameByAcc: function (userAccount, callBack, onError)
            {
                var sendStr = YTX_CONFIG._protobuf._buildGetNickByAcc(userAccount, callBack, onError);
                if (!!sendStr)
                {
                    YTX_CONFIG._sendMsg(sendStr)
                }
            },
            getMyInfo: function (callback, onError)
            {
                var sendStr = YTX_CONFIG._protobuf._buildGetMyInfo(callback, onError);
                if (!!sendStr)
                {
                    YTX_CONFIG._sendMsg(sendStr)
                }
            },
            uploadPersonInfo: function (uploadPersonInfoBuilder, callback, onError)
            {
                var sendStr = YTX_CONFIG._protobuf._buildSetMyInfo(uploadPersonInfoBuilder, callback, onError);
                if (!!sendStr)
                {
                    YTX_CONFIG._sendMsg(sendStr)
                }
            },
            uploadPerfonInfo: function (uploadPersonInfoBuilder, callback, onError)
            {
                var sendStr = YTX_CONFIG._protobuf._buildSetMyInfo(uploadPersonInfoBuilder, callback, onError);
                if (!!sendStr)
                {
                    YTX_CONFIG._sendMsg(sendStr)
                }
            },
            getHistoryMessage: function (GetHistoryMsgBuilder, callback, onError)
            {
                var sendStr = YTX_CONFIG._protobuf._buildGetHistoryMessage(GetHistoryMsgBuilder, callback, onError);
                if (!!sendStr)
                {
                    YTX_CONFIG._sendMsg(sendStr)
                }
            },
            createGroup: function (CreateGroupBuilder, callback, onError)
            {
                var sendStr = YTX_CONFIG._protobuf._buildCreateGroup(CreateGroupBuilder, callback, onError);
                if (!!sendStr)
                {
                    YTX_CONFIG._sendMsg(sendStr)
                }
            },
            dismissGroup: function (DismissGroupBuilder, callback, onError)
            {
                var sendStr = YTX_CONFIG._protobuf._buildDismissGroup(DismissGroupBuilder, callback, onError);
                if (!!sendStr)
                {
                    YTX_CONFIG._sendMsg(sendStr)
                }
            },
            inviteJoinGroup: function (InviteJoinGroupBuilder, callback, onError)
            {
                var sendStr = YTX_CONFIG._protobuf._buildInviteJoinGroupr(InviteJoinGroupBuilder, callback, onError);
                if (!!sendStr)
                {
                    YTX_CONFIG._sendMsg(sendStr)
                }
            },
            confirmInviteJoinGroup: function (ConfirmInviteJoinGroupBuilder, callback, onError)
            {
                var sendStr = YTX_CONFIG._protobuf._buildConfirmInviteJoinGroupr(ConfirmInviteJoinGroupBuilder, callback, onError);
                if (!!sendStr)
                {
                    YTX_CONFIG._sendMsg(sendStr)
                }
            },
            quitGroup: function (QuitGroupBuilder, callback, onError)
            {
                var sendStr = YTX_CONFIG._protobuf._buildQuitGroup(QuitGroupBuilder, callback, onError);
                if (!!sendStr)
                {
                    YTX_CONFIG._sendMsg(sendStr)
                }
            },
            getGroupList: function (GetGroupListBuilder, callback, onError)
            {
                var sendStr = YTX_CONFIG._protobuf._buildGetGroupList(GetGroupListBuilder, callback, onError);
                if (!!sendStr)
                {
                    YTX_CONFIG._sendMsg(sendStr)
                }
            },
            getGroupMemberList: function (GetGroupMemberListBuilder, callback, onError)
            {
                var sendStr = YTX_CONFIG._protobuf._buildGetGroupMemberList(GetGroupMemberListBuilder, callback, onError);
                if (!!sendStr)
                {
                    YTX_CONFIG._sendMsg(sendStr)
                }
            },
            joinGroup: function (JoinGroupBuilder, callback, onError)
            {
                var sendStr = YTX_CONFIG._protobuf._buildJoinGroup(JoinGroupBuilder, callback, onError);
                if (!!sendStr)
                {
                    YTX_CONFIG._sendMsg(sendStr)
                }
            },
            confirmJoinGroup: function (ConfirmJoinGroupBuilder, callback, onError)
            {
                var sendStr = YTX_CONFIG._protobuf._buildConfirmJoinGroup(ConfirmJoinGroupBuilder, callback, onError);
                if (!!sendStr)
                {
                    YTX_CONFIG._sendMsg(sendStr)
                }
            },
            getGroupDetail: function (GetGroupDetailBuilder, callback, onError)
            {
                var sendStr = YTX_CONFIG._protobuf._buildGetGroupDetail(GetGroupDetailBuilder, callback, onError);
                if (!!sendStr)
                {
                    YTX_CONFIG._sendMsg(sendStr)
                }
            },
            searchGroups: function (SearchGroupsBuilder, callback, onError)
            {
                var sendStr = YTX_CONFIG._protobuf._buildSearchGroups(SearchGroupsBuilder, callback, onError);
                if (!!sendStr)
                {
                    YTX_CONFIG._sendMsg(sendStr)
                }
            },
            deleteGroupMember: function (DeleteGroupMemberBuilder, callback, onError)
            {
                var sendStr = YTX_CONFIG._protobuf._buildDeleteGroupMember(DeleteGroupMemberBuilder, callback, onError);
                if (!!sendStr)
                {
                    YTX_CONFIG._sendMsg(sendStr)
                }
            },
            forbidMemberSpeak: function (ForbidMemberSpeakBuilder, callback, onError)
            {
                var sendStr = YTX_CONFIG._protobuf._buildForbidMemberSpeak(ForbidMemberSpeakBuilder, callback, onError);
                if (!!sendStr)
                {
                    YTX_CONFIG._sendMsg(sendStr)
                }
            },
            setGroupMessageRule: function (SetGroupMessageRuleBuilder, callback, onError)
            {
                var sendStr = YTX_CONFIG._protobuf._buildSetGroupMessageRule(SetGroupMessageRuleBuilder, callback, onError);
                if (!!sendStr)
                {
                    YTX_CONFIG._sendMsg(sendStr)
                }
            },
            queryGroupMemberCard: function (QueryGroupMemberCardBuilder, callback, onError)
            {
                var sendStr = YTX_CONFIG._protobuf._buildQueryGroupMemberCard(QueryGroupMemberCardBuilder, callback, onError);
                if (!!sendStr)
                {
                    YTX_CONFIG._sendMsg(sendStr)
                }
            },
            modifyMemberCard: function (ModifyMemberCardBuilder, callback, onError)
            {
                var sendStr = YTX_CONFIG._protobuf._buildModifyMemberCard(ModifyMemberCardBuilder, callback, onError);
                if (!!sendStr)
                {
                    YTX_CONFIG._sendMsg(sendStr)
                }
            },
            modifyGroup: function (ModifyGroupBuilder, callback, onError)
            {
                var sendStr = YTX_CONFIG._protobuf._buildModifyGroup(ModifyGroupBuilder, callback, onError);
                if (!!sendStr)
                {
                    YTX_CONFIG._sendMsg(sendStr)
                }
            },
            getUserState: function (GetUserStateBuilder, callback, onError)
            {
                _newUserState = GetUserStateBuilder.getNewUserstate() ? true : false;
                var sendStr = YTX_CONFIG._protobuf._buildGetUserState(GetUserStateBuilder, callback, onError);
                if (!!sendStr)
                {
                    YTX_CONFIG._sendMsg(sendStr)
                }
            },
            setGroupMemberRole: function (SetGroupMemberRoleBuilder, callback, onError)
            {
                var sendStr = YTX_CONFIG._protobuf._buildSetGroupMemberRole(SetGroupMemberRoleBuilder, callback, onError);
                if (!!sendStr)
                {
                    YTX_CONFIG._sendMsg(sendStr)
                }
            },
            setCallView: function (view, localView, hideView)
            {
                YTX_CONFIG._voipCallData._voipOtherView = view;
                YTX_CONFIG._voipCallData._voipLocalView = localView
            },
            msgOperation: function (MsgOperationBuilder, callback, onerror)
            {
                var sendStr = YTX_CONFIG._protobuf._buildMsgOperation(MsgOperationBuilder, callback, onerror);
                console.log(sendStr);
                if (!!sendStr)
                {
                    YTX_CONFIG._sendMsg(sendStr)
                }
            },
            setTimeWindow: function (obj)
            {
                if (!!obj.jquery)
                {
                    obj = obj[0]
                }
                YTX_CONFIG._voipTimer = setInterval(function ()
                {
                    var second = YTX_CONFIG._voipTimestamp++;
                    var minute = 0;
                    var hours = 0;
                    if (second > 59)
                    {
                        minute = parseInt(second / 60);
                        second = second % 60
                    }
                    if (minute > 59)
                    {
                        hours = parseInt(second / 60);
                        second = second % 60
                    }
                    console.log(second);
                    if (!!obj)
                    {
                        obj.innerHTML = hours + " : " + minute + " : " + second
                    }
                }, 1000)
            },
            makeCall: function (MakeCallBuilder, callback, onError)
            {
                if (!YTX_CONFIG.util.getUserMedia())
                {
                    var resp = {};
                    resp.code = YTX_CONFIG._errcode._VOIP_NO_MEDIA;
                    resp.msg = 'brower not support getUserMedia.';
                    onError(resp);
                    return
                }
                var timeStamp = new Date().getTime();
                var randomNum = "";
                for (var i = 0; i < 6; i++)
                {
                    randomNum += Math.floor(Math.random() * 10)
                }
                var callId = timeStamp + randomNum;
                YTX_CONFIG._voipCallData._callEventCallId = callId;
                var us_data = ("tel=" + (MakeCallBuilder.getTel() ? MakeCallBuilder.getTel() : '')) + ';' + ('nickName=' + MakeCallBuilder.getNickName());
                var CallEventBuilder = new YTX_CONFIG._protobuf._CallEventData(1, callId, MakeCallBuilder.getCallType(), MakeCallBuilder.getCalled(), YTX_CONFIG._userName, us_data);
                YTX_CONFIG._sendVoip(CallEventBuilder, callback, onError);
                return callId
            },
            accetpCall: function (AcceptCallBuilder, callback, onError)
            {
                var CallEventBuilder = new YTX_CONFIG._protobuf._CallEventData(4, AcceptCallBuilder.getCallId(), null, YTX_CONFIG._userName, AcceptCallBuilder.getCaller());
                YTX_CONFIG._sendVoip(CallEventBuilder, callback, onError)
            },
            rejectCall: function (RejectCallBuilder, callback, onError)
            {
                var CallEventBuilder = new YTX_CONFIG._protobuf._CallEventData(10, RejectCallBuilder.getCallId(), null, YTX_CONFIG._userName, RejectCallBuilder.getCaller(), null, null, '603');
                var sendStr = YTX_CONFIG._protobuf._buildCallEvent(CallEventBuilder, callback, onError);
                YTX_CONFIG._voipCallData._callEventCallId = null;
                if (!!sendStr)
                {
                    YTX_CONFIG._sendMsg(sendStr)
                }
                YTX_CONFIG._releaseVoip();
                if (!!RejectCallBuilder._callId)
                {
                    delete YTX_CONFIG._voipCallData._msgRouterMap[RejectCallBuilder._callId]
                }
            },
            releaseCall: function (ReleaseCallBuilder, callback, onError)
            {
                var callEventType = 7;
                if (!!YTX_CONFIG._voipTimer)
                {
                    clearInterval(YTX_CONFIG._voipTimer);
                    YTX_CONFIG._voipTimer = null;
                    YTX_CONFIG._voipTimestamp = 0
                }
                if (ReleaseCallBuilder.getCaller() == YTX_CONFIG._userName && !YTX_CONFIG._voipCallData._connected)
                {
                    callEventType = 8
                }
                else if (YTX_CONFIG._voipCallData._called == YTX_CONFIG._userName && !YTX_CONFIG._voipCallData._connected)
                {
                    var rejectCallBuilder = new RL_YTX.RejectCallBuilder();
                    rejectCallBuilder.setCallId(YTX_CONFIG._voipCallData._callId);
                    rejectCallBuilder.setCaller(YTX_CONFIG._voipCallData._caller);
                    RL_YTX.rejectCall(rejectCallBuilder, function (sucObj)
                    {
                    }, function (errObj)
                    {
                    })
                }
                var CallEventBuilder = new YTX_CONFIG._protobuf._CallEventData(callEventType, ReleaseCallBuilder.getCallId(), null, ReleaseCallBuilder.getCalled(), ReleaseCallBuilder.getCaller());
                var sendStr = YTX_CONFIG._protobuf._buildCallEvent(CallEventBuilder, callback, onError);
                if (!!sendStr)
                {
                    YTX_CONFIG._sendMsg(sendStr)
                }
                ;
                YTX_CONFIG._releaseVoip();
                if (!!ReleaseCallBuilder._callId)
                {
                    delete YTX_CONFIG._voipCallData._msgRouterMap[ReleaseCallBuilder._callId]
                }
                ;
                YTX_CONFIG._voipCallData._releaseCallback = callback;
                YTX_CONFIG._voipCallData._releaseCallbackError = onError
            },
            deleteReadMsg: function (DeleteReadMsgBuilder, callback, onError)
            {
                YTX_CONFIG._deleteReadMsgMap[DeleteReadMsgBuilder.getMsgid()] = true;
                console.log(YTX_CONFIG._deleteReadMsgMap);
                var sendStr = YTX_CONFIG._protobuf._buildDeleteReadMsg(DeleteReadMsgBuilder, callback, onError);
                if (!!sendStr)
                {
                    YTX_CONFIG._sendMsg(sendStr)
                }
            },
            presetSynMsgLimit: function (numLimit, callback, onError)
            {
                if (!isNaN(numLimit) && numLimit >= 0)
                {
                    YTX_CONFIG._synMsgMaxNumLimit = numLimit;
                    var respObj = new Object();
                    respObj.code = YTX_CONFIG._errcode._SUCC;
                    callback(respObj)
                }
                else
                {
                    var respObj = new Object();
                    respObj.code = YTX_CONFIG._errcode._CHARSET_ILLEGAl;
                    respObj.msg = "只允许不小于0的整数参数";
                    onError(respObj)
                }
            },
            getRecentContactList: function (GetRecentContactListBuilder, callback, onError)
            {
                var sendStr = YTX_CONFIG._protobuf._buildGetRecentContactList(GetRecentContactListBuilder, callback, onError);
                if (!!sendStr)
                {
                    YTX_CONFIG._sendMsg(sendStr)
                }
            },
            uploadUserDevice: function (callback, onError)
            {
                var sendStr = YTX_CONFIG._protobuf._(GetRecentContactListBuilder, callback, onError);
                if (!!sendStr)
                {
                    YTX_CONFIG._sendMsg(sendStr)
                }
            },
            getFileSource: function (url, callback, onError)
            {
                console.log("getFileSource  +++++++++++++++   ");
                console.log(url);
                var sendStr = YTX_CONFIG._protobuf._buildGetFileSource(url, callback, onError);
                if (!!sendStr)
                {
                    var fileurl = Base64.decode(YTX_CONFIG._file_server_url);
                    var ws = new WebSocket(fileurl);
                    var tId = setTimeout(function ()
                    {
                        YTX_CONFIG._log(YTX_CONFIG._logLev._INFO, "getFileSource timeout...");
                        ws.close()
                    }, (YTX_CONFIG._timeOutSecond * 1000));
                    ws.tid = tId;
                    ws.onopen = function ()
                    {
                        console.log("getFileSource : sendStr =" + sendStr);
                        ws.send(sendStr)
                    };
                    ws.onmessage = function (evt)
                    {
                        readBlobAsDataURL(evt.data, function (dataurl)
                        {
                            var resp = {};
                            resp.url = dataurl;
                            console.log(dataurl);
                            callback(resp)
                        });
                        ws.close();
                        if (!!tId)
                        {
                            clearTimeout(tId)
                        }
                        ;
                        function readBlobAsDataURL(blob, callback)
                        {
                            var fr = new FileReader();
                            fr.readAsBinaryString(blob);
                            fr.onload = function (a)
                            {
                                var re = a.target.result;
                                try
                                {
                                    var binary = pako.inflate(re, {"gzip": true, "windowBits": 32});
                                    var b = new Blob([binary], {type: "application/octet-binary"});
                                    var url = window.URL.createObjectURL(b);
                                    callback(url)
                                } catch (e)
                                {
                                    console.log(e);
                                    var str = {};
                                    str["code"] = "null";
                                    str["msg"] = "uncompressing error ";
                                    onError(str)
                                }
                            };
                            fr.onerror = errorHandler;
                            function errorHandler(evt)
                            {
                                switch (evt.target.error.code)
                                {
                                    case evt.target.error.NOT_FOUND_ERR:
                                        console.log('File Not Found!');
                                        break;
                                    case evt.target.error.NOT_READABLE_ERR:
                                        console.log('File is not readable');
                                        break;
                                    case evt.target.error.ABORT_ERR:
                                        break;
                                    default:
                                        console.log('An error occurred reading this file.')
                                }
                                ;
                                var resp = {};
                                resp.code = YTX_CONFIG._errcode._FILE_FILEREADER_ERROR;
                                resp.msg = "method FileReader() occur error！";
                                onError(resp)
                            }
                        }
                    };
                    ws.onerror = function ()
                    {
                        console.log("WebSocketError!");
                        var resp = {};
                        resp.code = YTX_CONFIG._errcode._FILE_SOURCE_ERROR;
                        resp.msg = "WebSocketError!";
                        onError(resp)
                    };
                    ws.onclose = function (evt)
                    {
                        console.log("WebSocketClosed!")
                    }
                }
            },
            onMsgReceiveListener: function (callback)
            {
                YTX_CONFIG._pushListener = callback
            },
            onMsgNotifyReceiveListener: function (callback)
            {
                YTX_CONFIG._msgNotifyListener = callback
            },
            onMCMMsgReceiveListener: function (callback)
            {
                YTX_CONFIG._mcmListener = callback
            },
            onMCMNoticeReceiveListener: function (callback)
            {
                YTX_CONFIG._mcmNoticeListener = callback
            },
            onNoticeReceiveListener: function (callback)
            {
                YTX_CONFIG._noticeListener = callback
            },
            onConnectStateChangeLisenter: function (callback)
            {
                YTX_CONFIG._connectStatListener = callback
            },
            onCallMsgListener: function (callback)
            {
                YTX_CONFIG._voipListener = callback
            },
            LoginBuilder: function (type, userName, pwd, sig, timestamp)
            {
                this._type = type;
                this._userName = userName;
                this._pwd = pwd;
                this._sig = sig;
                this._timestamp = timestamp;
                this.setType = function (type)
                {
                    this._type = type
                };
                this.setUserName = function (userName)
                {
                    this._userName = userName
                };
                this.setPwd = function (pwd)
                {
                    this._pwd = pwd
                };
                this.setSig = function (sig)
                {
                    this._sig = sig
                };
                this.setTimestamp = function (timestamp)
                {
                    this._timestamp = timestamp
                };
                this.getType = function ()
                {
                    return this._type
                };
                this.getUserName = function ()
                {
                    return this._userName
                };
                this.getPwd = function ()
                {
                    return this._pwd
                };
                this.getSig = function ()
                {
                    return this._sig
                };
                this.getTimestamp = function ()
                {
                    return this._timestamp
                }
            },
            MsgBuilder: function (id, content, file, type, receiver, domain, fileName, atAccounts)
            {
                this._id = id;
                this._text = content;
                this._file = file;
                this._type = (!!type) ? type : 1;
                this._receiver = receiver;
                this._domain = domain;
                this._fileName = fileName;
                this._atAccounts = atAccounts;
                this.setId = function (id)
                {
                    this._id = id
                };
                this.setText = function (text)
                {
                    this._text = text
                };
                this.setFile = function (file)
                {
                    this._file = file
                };
                this.setType = function (type)
                {
                    this._type = type
                };
                this.setReceiver = function (receiver)
                {
                    this._receiver = receiver
                };
                this.setDomain = function (domain)
                {
                    this._domain = domain
                };
                this.setFileName = function (fileName)
                {
                    this._fileName = fileName
                };
                this.setAtAccounts = function (atAccounts)
                {
                    this._atAccounts = atAccounts
                };
                this.getId = function ()
                {
                    return this._id
                };
                this.getText = function ()
                {
                    return this._text
                };
                this.getFile = function ()
                {
                    return this._file
                };
                this.getType = function ()
                {
                    return this._type
                };
                this.getReceiver = function ()
                {
                    return this._receiver
                };
                this.getDomain = function ()
                {
                    return this._domain
                };
                this.getFileName = function ()
                {
                    return this._fileName
                };
                this.getAtAccounts = function ()
                {
                    return this._atAccounts
                }
            },
            _mcmType: {
                _mcmType_text: 1,
                _mcmType_audio: 2,
                _mcmType_video: 3,
                _mcmType_pic: 4,
                _mcmType_pos: 5,
                _mcmType_file: 6
            },
            MCMAgentInfoBuilder: function (agentId, imState, telState, number, customaccnum, firstnumber, acdcalltype, pushVoipacc, queueType, queuePriority, userInfoCallbackurl, delayCall, maxImUser, agentServerMode, answerTimeout)
            {
                this._agentId = agentId;
                this._imState = imState;
                this._telState = telState;
                this._number = number;
                this._customaccnum = customaccnum;
                this._firstnumber = firstnumber;
                this._acdcalltype = acdcalltype;
                this._pushVoipacc = pushVoipacc;
                this._queueType = queueType;
                this._queuePriority = queuePriority;
                this._userInfoCallbackurl = userInfoCallbackurl;
                this._delayCall = delayCall;
                this._maxImUser = maxImUser;
                this._agentServerMode = agentServerMode;
                this._answerTimeout = answerTimeout;
                this.setAgentId = function (agentId)
                {
                    this._agentId = agentId
                };
                this.setImState = function (imState)
                {
                    this._imState = imState
                };
                this.setTelState = function (telState)
                {
                    this._telState = telState
                };
                this.setNumber = function (number)
                {
                    this._number = number
                };
                this.setCustomaccnum = function (customaccnum)
                {
                    this._customaccnum = customaccnum
                };
                this.setFirstnumber = function (firstnumber)
                {
                    this._firstnumber = firstnumber
                };
                this.setAcdcalltype = function (acdcalltype)
                {
                    this._acdcalltype = acdcalltype
                };
                this.setPushVoipacc = function (pushVoipacc)
                {
                    this._pushVoipacc = pushVoipacc
                };
                this.setQueueType = function (queueType)
                {
                    this._queueType = queueType
                };
                this.setQueuePriority = function (queuePriority)
                {
                    this._queuePriority = queuePriority
                };
                this.setUserInfoCallbackurl = function (userInfoCallbackurl)
                {
                    this._userInfoCallbackurl = userInfoCallbackurl
                };
                this.setDelayCall = function (delayCall)
                {
                    this._delayCall = delayCall
                };
                this.setMaxImUser = function (maxImUser)
                {
                    this._maxImUser = maxImUser
                };
                this.setAgentServerMode = function (agentServerMode)
                {
                    this._agentServerMode = agentServerMode
                };
                this.setAnswerTimeout = function (answerTimeout)
                {
                    this._answerTimeout = answerTimeout
                };
                this.getAgentId = function ()
                {
                    return this._agentId
                };
                this.getImState = function ()
                {
                    return this._imState
                };
                this.getTelState = function ()
                {
                    return this._telState
                };
                this.getNumber = function ()
                {
                    return this._number
                };
                this.getCustomaccnum = function ()
                {
                    return this._customaccnum
                };
                this.getFirstnumber = function ()
                {
                    return this._firstnumber
                };
                this.getAcdcalltype = function ()
                {
                    return this._acdcalltype
                };
                this.getPushVoipacc = function ()
                {
                    return this._pushVoipacc
                };
                this.getQueueType = function ()
                {
                    return this._queueType
                };
                this.getQueuePriority = function ()
                {
                    return this._queuePriority
                };
                this.getUserInfoCallbackurl = function ()
                {
                    return this._userInfoCallbackurl
                };
                this.getDelayCall = function ()
                {
                    return this._delayCall
                };
                this.getMaxImUser = function ()
                {
                    return this._maxImUser
                };
                this.getAgentServerMode = function ()
                {
                    return this._agentServerMode
                };
                this.getAnswerTimeout = function ()
                {
                    return this._answerTimeout
                }
            },
            MCMDataBuilder: function (ccpCustomData)
            {
                this._ccpCustomData = ccpCustomData;
                this.setCcpCustomData = function (ccpCustomData)
                {
                    this._ccpCustomData = ccpCustomData
                };
                this.getCcpCustomData = function ()
                {
                    return this._ccpCustomData
                }
            },
            MCMMessageBuilder: function (content, file, type, msgType, userData, account, msgId, fileName, chanType, mailTitle)
            {
                this._content = content;
                this._userData = userData;
                this._account = account;
                this._msgId = msgId;
                this._file = file;
                this._msgType = (!!msgType) ? msgType : RL_YTX._mcmType._mcmType_text;
                this._fileName = fileName;
                this._chanType = chanType;
                this._mailTitle = mailTitle;
                this.setContent = function (content)
                {
                    this._content = content
                };
                this.setFile = function (file)
                {
                    this._file = file
                };
                this.setMsgType = function (msgType)
                {
                    this._msgType = msgType
                };
                this.setAccount = function (account)
                {
                    this._account = account
                };
                this.setMsgId = function (msgId)
                {
                    this._msgId = msgId
                };
                this.setUserData = function (userData)
                {
                    this._userData = userData
                };
                this.setFileName = function (fileName)
                {
                    this._fileName = fileName
                };
                this.setChanType = function (chanType)
                {
                    this._chanType = chanType
                };
                this.setMailTitle = function (mailTitle)
                {
                    this._mailTitle = mailTitle
                };
                this.getMsgId = function ()
                {
                    return this._msgId
                };
                this.getContent = function ()
                {
                    return this._content
                };
                this.getFile = function ()
                {
                    return this._file
                };
                this.getMsgType = function ()
                {
                    return this._msgType
                };
                this.getUserData = function ()
                {
                    return this._userData
                };
                this.getAccount = function ()
                {
                    return this._account
                };
                this.getMsgType = function ()
                {
                    return this._msgType
                };
                this.getFileName = function ()
                {
                    return this._fileName
                };
                this.getChanType = function ()
                {
                    return this._chanType
                };
                this.getMailTitle = function ()
                {
                    return this._mailTitle
                }
            },
            SyncMsgBuilder: function (sVersion, eVersion, type)
            {
                this._sVersion = sVersion;
                this._eVersion = eVersion;
                this._type = type;
                this.setSVersion = function (sVersion)
                {
                    this._sVersion = sVersion
                };
                this.setEVersion = function (eVersion)
                {
                    this._eVersion = eVersion
                };
                this.setType = function (type)
                {
                    this._type = type
                };
                this.getSVersion = function ()
                {
                    return this._sVersion
                };
                this.getEVersion = function ()
                {
                    return this._eVersion
                };
                this.getType = function ()
                {
                    return this._type
                }
            },
            UploadPersonInfoBuilder: function (nickName, sex, birth, sign)
            {
                this._nickName = nickName;
                this._sex = (!!sex) ? sex : 1;
                this._birth = birth;
                this._sign = sign;
                this.setNickName = function (nickName)
                {
                    this._nickName = nickName
                };
                this.setSex = function (sex)
                {
                    this._sex = sex
                };
                this.setBirth = function (birth)
                {
                    this._birth = birth
                };
                this.setSign = function (sign)
                {
                    this._sign = sign
                };
                this.getNickName = function ()
                {
                    return this._nickName
                };
                this.getSex = function ()
                {
                    return this._sex
                };
                this.getBirth = function ()
                {
                    return this._birth
                };
                this.getSign = function ()
                {
                    return this._sign
                }
            },
            GetHistoryMsgBuilder: function (talker, pageSize, operator, msgId, order, sig)
            {
                this._talker = talker;
                this._pageSize = (!!pageSize) ? pageSize : 10;
                this._operator = operator;
                this._msgId = msgId;
                this._order = order;
                this._sig = sig;
                this.setTalker = function (talker)
                {
                    this._takler = talker
                };
                this.setPageSize = function (pageSize)
                {
                    if (!pageSize)
                    {
                        pageSize = 10
                    }
                    this._pageSize = pageSize
                };
                this.setOperator = function (operator)
                {
                    this._operator = operator
                };
                this.setMsgId = function (msgId)
                {
                    this._msgId = msgId
                };
                this.setOrder = function (order)
                {
                    this._order = order
                };
                this.getTalker = function ()
                {
                    return this._talker
                };
                this.getPageSize = function ()
                {
                    return this._pageSize
                };
                this.getOperator = function ()
                {
                    return this._operator
                };
                this.getMsgId = function ()
                {
                    return this._msgId
                };
                this.getOrder = function ()
                {
                    return this._order
                }
            },
            CreateGroupBuilder: function (groupName, groupType, province, city, scope, declared, permission, mode, groupDomain, target)
            {
                this._groupName = groupName;
                this._groupType = (!!groupType) ? groupType : 2;
                this._province = province;
                this._city = city;
                this._scope = (!!scope) ? scope : 1;
                this._declared = declared;
                this._permission = (!!permission) ? permission : 1;
                this._mode = (!!mode) ? mode : 1;
                this._groupDomain = groupDomain;
                this._target = target;
                this.setGroupName = function (groupName)
                {
                    this._groupName = groupName
                };
                this.setGroupType = function (groupType)
                {
                    this._groupType = groupType
                };
                this.setProvince = function (province)
                {
                    this._province = province
                };
                this.setCity = function (city)
                {
                    this._city = city
                };
                this.setScope = function (scope)
                {
                    this._scope = scope
                };
                this.setDeclared = function (declared)
                {
                    this._declared = declared
                };
                this.setPermission = function (permission)
                {
                    this._permission = permission
                };
                this.setMode = function (mode)
                {
                    this._mode = mode
                };
                this.setGroupDomain = function (domain)
                {
                    this._groupDomain = domain
                };
                this.setTarget = function (target)
                {
                    this._target = target
                };
                this.getGroupName = function ()
                {
                    return this._groupName
                };
                this.getGroupType = function ()
                {
                    if (!!this._groupType)
                    {
                        return this._groupType
                    }
                    return 1
                };
                this.getProvince = function ()
                {
                    return this._province
                };
                this.getCity = function ()
                {
                    return this._city
                };
                this.getScope = function ()
                {
                    if (!!this._scope)
                    {
                        return this._scope
                    }
                    return 1
                };
                this.getDeclared = function ()
                {
                    return this._declared
                };
                this.getPermission = function ()
                {
                    if (!!this._permission)
                    {
                        return this._permission
                    }
                    return 1
                };
                this.getMode = function ()
                {
                    if (!!this._mode)
                    {
                        return this._mode
                    }
                    return 1
                };
                this.getGroupDomain = function ()
                {
                    return this._groupDomain
                };
                this.getTarget = function ()
                {
                    return this._target
                }
            },
            DismissGroupBuilder: function (groupId)
            {
                this._groupId = groupId;
                this.setGroupId = function (groupId)
                {
                    this._groupId = groupId
                };
                this.getGroupId = function ()
                {
                    return this._groupId
                }
            },
            InviteJoinGroupBuilder: function (groupId, declared, members, confirm)
            {
                this._groupId = groupId;
                this._declared = declared;
                this._members = members;
                this._confirm = (!!confirm) ? confirm : 2;
                this.setGroupId = function (groupId)
                {
                    this._groupId = groupId
                };
                this.setDeclared = function (declared)
                {
                    this._declared = declared
                };
                this.setMembers = function (members)
                {
                    this._members = members
                };
                this.setConfirm = function (confirm)
                {
                    this._confirm = confirm
                };
                this.getGroupId = function ()
                {
                    return this._groupId
                };
                this.getDeclared = function ()
                {
                    return this._declared
                };
                this.getMembers = function ()
                {
                    return this._members
                };
                this.getConfirm = function ()
                {
                    return this._confirm
                }
            },
            ConfirmInviteJoinGroupBuilder: function (invitor, groupId, confirm)
            {
                this._invitor = invitor;
                this._groupId = groupId;
                this._confirm = (!!confirm) ? confirm : 1;
                this.setInvitor = function (invitor)
                {
                    this._invitor = invitor
                };
                this.setGroupId = function (groupId)
                {
                    this._groupId = groupId
                };
                this.setConfirm = function (confirm)
                {
                    this._confirm = confirm
                };
                this.getInvitor = function ()
                {
                    return this._invitor
                };
                this.getGroupId = function ()
                {
                    return this._groupId
                };
                this.getConfirm = function ()
                {
                    return this._confirm
                }
            },
            QuitGroupBuilder: function (groupId)
            {
                this._groupid = groupId;
                this.setGroupId = function (groupId)
                {
                    this._groupid = groupId
                };
                this.getGroupId = function ()
                {
                    return this._groupid
                }
            },
            GetGroupListBuilder: function (groupId, pageSize, target)
            {
                this._groupId = groupId;
                this._pageSize = (!!pageSize) ? pageSize : 50;
                this._target = isNaN(target) ? undefined : target;
                this.setGroupId = function (groupId)
                {
                    this._groupId = groupId
                };
                this.setPageSize = function (pageSize)
                {
                    this._pageSize = pageSize
                };
                this.setTarget = function (target)
                {
                    if (isNaN(target))
                    {
                        target = undefined
                    }
                    this._target = target
                };
                this.getGroupId = function ()
                {
                    return this._groupId
                };
                this.getPageSize = function ()
                {
                    return this._pageSize
                };
                this.getTarget = function ()
                {
                    return this._target
                }
            },
            GetGroupMemberListBuilder: function (groupId, memberId, pageSize)
            {
                this._groupId = groupId;
                this._memberId = memberId;
                this._pageSize = (!!pageSize) ? pageSize : 50;
                this.setGroupId = function (groupId)
                {
                    this._groupId = groupId
                };
                this.setPageSize = function (pageSize)
                {
                    this._pageSize = pageSize
                };
                this.setMemberId = function (memberId)
                {
                    this._memberId = memberId
                };
                this.getGroupId = function ()
                {
                    return this._groupId
                };
                this.getPageSize = function ()
                {
                    return this._pageSize
                };
                this.getMemberId = function ()
                {
                    return this._memberId
                }
            },
            JoinGroupBuilder: function (groupId, declared)
            {
                this._groupId = groupId;
                this._declared = (!!declared) ? declared : '';
                this.setGroupId = function (groupId)
                {
                    this._groupId = groupId
                };
                this.setDeclared = function (declared)
                {
                    if (!declared)
                    {
                        declared = ''
                    }
                    this._declared = declared
                };
                this.getGroupId = function ()
                {
                    return this._groupId
                };
                this.getDeclared = function ()
                {
                    return this._declared
                }
            },
            ConfirmJoinGroupBuilder: function (groupId, memberId, confirm)
            {
                this._groupId = groupId;
                this._memberId = memberId;
                this._confirm = confirm;
                this.setGroupId = function (groupId)
                {
                    this._groupId = groupId
                };
                this.setMemberId = function (memberId)
                {
                    this._memberId = memberId
                };
                this.setConfirm = function (confirm)
                {
                    this._confirm = confirm
                };
                this.getGroupId = function ()
                {
                    return this._groupId
                };
                this.getMemberId = function ()
                {
                    return this._memberId
                };
                this.getConfirm = function ()
                {
                    return this._confirm
                }
            },
            GetGroupDetailBuilder: function (groupId)
            {
                this._groupId = groupId;
                this.setGroupId = function (groupId)
                {
                    this._groupId = groupId
                };
                this.getGroupId = function ()
                {
                    return this._groupId
                }
            },
            SearchGroupsBuilder: function (searchType, keywords)
            {
                this._searchType = searchType;
                this._keywords = keywords;
                this.setSearchType = function (searchType)
                {
                    this._searchType = searchType
                };
                this.setKeywords = function (keywords)
                {
                    this._keywords = keywords
                };
                this.getSearchType = function ()
                {
                    return this._searchType
                };
                this.getKeywords = function ()
                {
                    return this._keywords
                }
            },
            DeleteGroupMemberBuilder: function (groupId, memberId)
            {
                this._groupId = groupId;
                this._memberId = memberId;
                this.setGroupId = function (groupId)
                {
                    this._groupId = groupId
                };
                this.setMemberId = function (memberId)
                {
                    this._memberId = memberId
                };
                this.getGroupId = function ()
                {
                    return this._groupId
                };
                this.getMemberId = function ()
                {
                    return this._memberId
                }
            },
            ForbidMemberSpeakBuilder: function (groupId, memberId, forbidState)
            {
                this._groupId = groupId;
                this._memberId = memberId;
                this._forbidState = (!!forbidState && !isNaN(forbidState)) ? forbidState : 2;
                this.setGroupId = function (groupId)
                {
                    this._groupId = groupId
                };
                this.setMemberId = function (memberId)
                {
                    this._memberId = memberId
                };
                this.setForbidState = function (forbidState)
                {
                    if (!!forbidState && !isNaN(forbidState))
                    {
                        this._forbidState = forbidState
                    }
                    else
                    {
                        this._forbidState = 2
                    }
                };
                this.getGroupId = function ()
                {
                    return this._groupId
                };
                this.getMemberId = function ()
                {
                    return this._memberId
                };
                this.getForbidState = function ()
                {
                    if (!!this._forbidState)
                    {
                        return this._forbidState
                    }
                    else
                    {
                        return 2
                    }
                }
            },
            SetGroupMessageRuleBuilder: function (groupId, isNotice, isApplePush)
            {
                this._groupId = groupId;
                this._isNotice = (!!isNotice && !isNaN(isNotice)) ? isNotice : null;
                this._isApplePush = (!!isApplePush && !isNaN(isApplePush)) ? isNotice : null;
                this.setGroupId = function (groupId)
                {
                    this._groupId = groupId
                };
                this.setIsNotice = function (isNotice)
                {
                    if (!!isNotice && !isNaN(isNotice))
                    {
                        this._isNotice = isNotice
                    }
                    else
                    {
                        this._isNotice = null
                    }
                };
                this.setIsApplePush = function (isApplePush)
                {
                    if ((!!isApplePush && !isNaN(isApplePush)))
                    {
                        this._isApplePush = isApplePush
                    }
                    else
                    {
                        this._isApplePush = null
                    }
                };
                this.getGroupId = function ()
                {
                    return this._groupId
                };
                this.getIsNotice = function ()
                {
                    return this._isNotice
                };
                this.getIsApplePush = function ()
                {
                    return this._isApplePush
                }
            },
            QueryGroupMemberCardBuilder: function (memberId, belong)
            {
                this._memberId = memberId;
                this._belong = belong;
                this.setMemberId = function (memberId)
                {
                    this._memberId = memberId
                };
                this.setBelong = function (belong)
                {
                    this._belong = belong
                };
                this.getMemberId = function ()
                {
                    return this._memberId
                };
                this.getBelong = function ()
                {
                    return this._belong
                }
            },
            ModifyMemberCardBuilder: function (member, belong, display, phone, mail, remark)
            {
                this._member = member;
                this._belong = belong;
                this._display = display;
                this._phone = phone;
                this._mail = mail;
                this._remark = remark;
                this.setMember = function (member)
                {
                    this._member = member
                };
                this.setBelong = function (belong)
                {
                    this._belong = belong
                };
                this.setDisplay = function (display)
                {
                    this._display = display
                };
                this.setMail = function (mail)
                {
                    this._mail = mail
                };
                this.setPhone = function (phone)
                {
                    this._phone = phone
                };
                this.setRemark = function (remark)
                {
                    this._remark = remark
                };
                this.getMember = function ()
                {
                    return this._member
                };
                this.getBelong = function ()
                {
                    return this._belong
                };
                this.getDisplay = function ()
                {
                    return this._display
                };
                this.getPhone = function ()
                {
                    return this._phone
                };
                this.getMail = function ()
                {
                    return this._mail
                };
                this.getRemark = function ()
                {
                    return this._remark
                }
            },
            ModifyGroupBuilder: function (groupId, groupName, type, province, city, scope, declared, permission, groupDomain)
            {
                this._groupId = groupId;
                this._groupName = groupName;
                this._type = type;
                this._province = province;
                this._city = city;
                this._scope = scope;
                this._declared = declared;
                this._permission = permission;
                this._groupDomain = groupDomain;
                this.setGroupId = function (groupId)
                {
                    this._groupId = groupId
                };
                this.setGroupName = function (groupName)
                {
                    this._groupName = groupName
                };
                this.setType = function (type)
                {
                    if (!!type && !isNaN(type))
                    {
                        this._type = type
                    }
                    else
                    {
                        this._type = null
                    }
                };
                this.setProvince = function (province)
                {
                    this._province = province
                };
                this.setCity = function (city)
                {
                    this._city = city
                };
                this.setScope = function (scope)
                {
                    if (!!scope && !isNaN(scope))
                    {
                        this._scope = scope
                    }
                    else
                    {
                        this._scope = null
                    }
                };
                this.setDeclared = function (declared)
                {
                    this._declared = declared
                };
                this.setPermission = function (permission)
                {
                    if (!!permission && !isNaN(permission))
                    {
                        this._permission = permission
                    }
                    else
                    {
                        this._permission = null
                    }
                };
                this.setGroupDomain = function (groupDomain)
                {
                    this._groupDomain = groupDomain
                };
                this.getGroupId = function ()
                {
                    return this._groupId
                };
                this.getGroupName = function ()
                {
                    return this._groupName
                };
                this.getType = function ()
                {
                    return this._type
                };
                this.getProvince = function ()
                {
                    return this._province
                };
                this.getCity = function ()
                {
                    return this._city
                };
                this.getScope = function ()
                {
                    return this._scope
                };
                this.getDeclared = function ()
                {
                    return this._declared
                };
                this.getPermission = function ()
                {
                    return this._permission
                };
                this.getGroupDomain = function ()
                {
                    return this._groupDomain
                }
            },
            GetUserStateBuilder: function (useracc, newUserstate)
            {
                this._useracc = useracc;
                this._newUserstate = newUserstate;
                this.setNewUserstate = function (newUserstate)
                {
                    this._newUserstate = newUserstate
                };
                this.getNewUserstate = function ()
                {
                    return this._newUserstate
                };
                this.setUseracc = function (useracc)
                {
                    this._useracc = useracc
                };
                this.getUseracc = function ()
                {
                    return this._useracc
                }
            },
            SetGroupMemberRoleBuilder: function (groupId, memberId, role)
            {
                this._groupId = groupId;
                this._memberId = memberId;
                this._role = role;
                this.setGroupId = function (groupId)
                {
                    this._groupId = groupId
                };
                this.setMemberId = function (memberId)
                {
                    this._memberId = memberId
                };
                this.setRole = function (role)
                {
                    this._role = role
                };
                this.getGroupId = function (groupId)
                {
                    return this._groupId
                };
                this.getMemberId = function (memberId)
                {
                    return this._memberId
                };
                this.getRole = function (role)
                {
                    return this._role
                }
            },
            MakeCallBuilder: function (called, callType, tel, nickname)
            {
                this._called = called;
                this._callType = (!!callType) ? callType : 1;
                this._tel = tel;
                this._nickname = nickname;
                this.setCalled = function (called)
                {
                    this._called = called
                };
                this.setCallType = function (callType)
                {
                    this._callType = callType
                };
                this.setTel = function (tel)
                {
                    this._tel = tel
                };
                this.setNickName = function (nickname)
                {
                    this._nickname = nickname
                };
                this.getCalled = function ()
                {
                    return this._called
                };
                this.getCallType = function ()
                {
                    return this._callType
                };
                this.getTel = function ()
                {
                    return this._tel
                };
                this.getNickName = function ()
                {
                    return this._nickname
                }
            },
            AcceptCallBuilder: function (callId, caller)
            {
                this._callId = callId;
                this._caller = caller;
                this.setCallId = function (callId)
                {
                    this._callId = callId
                };
                this.setCaller = function (caller)
                {
                    this._caller = caller
                };
                this.getCallId = function ()
                {
                    return this._callId
                };
                this.getCaller = function ()
                {
                    return this._caller
                }
            },
            RejectCallBuilder: function (callId, caller, reason)
            {
                this._callId = callId;
                this._caller = caller;
                this.setCallId = function (callId)
                {
                    this._callId = callId
                };
                this.setCaller = function (caller)
                {
                    this._caller = caller
                };
                this.getCallId = function ()
                {
                    return this._callId
                };
                this.getCaller = function ()
                {
                    return this._caller
                }
            },
            ReleaseCallBuilder: function (callId, caller, called)
            {
                this._callId = callId;
                this._caller = caller;
                this._called = called;
                this.setCallId = function (callId)
                {
                    this._callId = callId
                };
                this.setCaller = function (caller)
                {
                    this._caller = caller
                };
                this.setCalled = function (called)
                {
                    this._called = called
                };
                this.getCallId = function ()
                {
                    return this._callId
                };
                this.getCaller = function ()
                {
                    return this._caller
                };
                this.getCalled = function ()
                {
                    return this._called
                }
            },
            DeleteReadMsgBuilder: function (version, msgid)
            {
                this._msgid = msgid;
                this.setMsgid = function (msgid)
                {
                    this._msgid = msgid
                };
                this.getMsgid = function ()
                {
                    return this._msgid
                }
            },
            MsgOperationBuilder: function (version, msgId, type)
            {
                this._version = version;
                this._msgId = msgId;
                this._type = type;
                this.setVersion = function (version)
                {
                    this._version = version
                };
                this.setMsgId = function (msgId)
                {
                    this._msgId = msgId
                };
                this.setType = function (type)
                {
                    this._type = type
                };
                this.getVersion = function ()
                {
                    return this._version
                };
                this.getMsgId = function ()
                {
                    return this._msgId
                };
                this.getType = function ()
                {
                    return this._type
                }
            },
            GetRecentContactListBuilder: function (time, limit)
            {
                this._time = time;
                this._limit = limit ? limit : 50;
                this.setTime = function (time)
                {
                    this._time = time
                };
                this.setLimit = function (limit)
                {
                    this._limit = limit
                };
                this.getTime = function ()
                {
                    return this._time
                };
                this.getLimit = function ()
                {
                    return this._pageSize
                }
            },
            photo: {
                apply: function (obj, onCanPlay, onError)
                {
                    PHOTO_CONFIG.state = 1;
                    var resp = {};
                    resp.code = 200;
                    var userMedia = YTX_CONFIG.util.getUserMedia();
                    if (!userMedia)
                    {
                        resp.code = YTX_CONFIG._errcode._VOIP_NO_MEDIA;
                        resp.msg = "brower not support getUserMedia";
                        onError(resp);
                        return
                    }
                    var video = null;
                    if (!!obj)
                    {
                        video = obj.tag
                    }
                    function onErr(error)
                    {
                        var resp = {};
                        switch (error.code || error.name)
                        {
                            case'PERMISSION_DENIED':
                            case'PermissionDeniedError':
                                YTX_CONFIG._log(YTX_CONFIG._logLev._INFO, '用户拒绝提供信息。');
                                resp.msg = 'user refuesed';
                                break;
                            case'NOT_SUPPORTED_ERROR':
                            case'NotSupportedError':
                                YTX_CONFIG._log(YTX_CONFIG._logLev._INFO, '浏览器不支持硬件设备。');
                                resp.msg = 'brower not support';
                                break;
                            case'MANDATORY_UNSATISFIED_ERROR':
                            case'MandatoryUnsatisfiedError':
                                YTX_CONFIG._log(YTX_CONFIG._logLev._INFO, '无法发现指定的硬件设备。');
                                resp.msg = 'can not find device';
                                break;
                            default:
                                YTX_CONFIG._log(YTX_CONFIG._logLev._INFO, '无法打开音视频。异常信息:' + (error.code || error.name));
                                resp.msg = 'can not open resource';
                                break
                        }
                        resp.code = YTX_CONFIG._errcode._VOIP_MEDIA_ERROR;
                        onError(resp)
                    }

                    if (PHOTO_CONFIG.mediaStream)
                    {
                        YTX_CONFIG.util.stopMediaStream(PHOTO_CONFIG.mediaStream);
                        PHOTO_CONFIG.mediaStream = null
                    }
                    function inputStream(stream)
                    {
                        if (PHOTO_CONFIG.state != 1)
                        {
                            YTX_CONFIG.util.stopMediaStream(stream);
                            return
                        }
                        var windowUrl = YTX_CONFIG.util.getWindowURL();
                        if (!!video)
                        {
                            if (!!windowUrl)
                            {
                                if (video.srcObject == undefined)
                                {
                                    video.src = windowUrl.createObjectURL(stream)
                                }
                                else
                                {
                                    video.srcObject = stream
                                }
                            }
                        }
                        else
                        {
                            video = document.createElement("video");
                            if (!!windowUrl)
                            {
                                if (video.srcObject == undefined)
                                {
                                    video.src = windowUrl.createObjectURL(stream)
                                }
                                else
                                {
                                    video.srcObject = stream
                                }
                            }
                        }
                        if (onCanPlay && onCanPlay instanceof Function)
                        {
                            if (video.addEventListener)
                            {
                                video.addEventListener('canplay', function ()
                                {
                                    onCanPlay()
                                })
                            }
                            else if (video.attachEvent)
                            {
                                video.attachEvent('oncanplay', function ()
                                {
                                    onCanPlay()
                                })
                            }
                        }
                        var width = 640;
                        var height = 480;
                        if ($(video).width() > 0)
                        {
                            width = $(video).width()
                        }
                        else
                        {
                            $(video).width(width)
                        }
                        if ($(video).height() > 0)
                        {
                            height = $(video).height()
                        }
                        else
                        {
                            $(video).height(height)
                        }
                        PHOTO_CONFIG.video = video;
                        PHOTO_CONFIG.mediaStream = stream
                    };
                    try
                    {
                        navigator.mediaDevices.getUserMedia({video: true, audio: false}).then(function (stream)
                        {
                            inputStream(stream)
                        }).catch(function (err)
                        {
                            console.log(err);
                            console.log("出错啦  getusermedia")
                        })
                    } catch (e)
                    {
                        userMedia.call(navigator, {video: true}, function (stream)
                        {
                            inputStream(stream)
                        }, onErr)
                    }
                }, make: function ()
                {
                    var resp = {};
                    resp.code = 200;
                    if (!PHOTO_CONFIG.mediaStream)
                    {
                        resp.code = YTX_CONFIG._errcode._NO_RESOURCE_STREAM;
                        resp.msg = "please execute apply methord first";
                        return resp
                    }
                    var video = PHOTO_CONFIG.video;
                    var windowUrl = YTX_CONFIG.util.getWindowURL();
                    var canvas = document.createElement("canvas");
                    var width = $(video).width();
                    var height = $(video).height();
                    $(canvas).attr("width", width);
                    $(canvas).attr("height", height);
                    var ctx = canvas.getContext('2d');
                    ctx.drawImage(video, 0, 0, width, height);
                    var dataurl = canvas.toDataURL('image/jpeg', 0.6);
                    canvas = null;
                    video = null;
                    var bin = atob(dataurl.split(',')[1]);
                    var buffer = new Uint8Array(bin.length);
                    for (var i = 0; i < bin.length; i++)
                    {
                        buffer[i] = bin.charCodeAt(i)
                    }
                    var blob = new Blob([buffer.buffer], {type: 'image/jpeg'});
                    if (windowUrl)
                    {
                        var url = windowUrl.createObjectURL(blob);
                        blob.url = url
                    }
                    YTX_CONFIG.util.stopMediaStream(PHOTO_CONFIG.mediaStream);
                    PHOTO_CONFIG.mediaStream = null;
                    var time = new Date().getTime();
                    blob.fileName = time + ".jpg";
                    resp.blob = blob;
                    return resp
                }, cancel: function ()
                {
                    PHOTO_CONFIG.state = 2;
                    var resp = {};
                    resp.code = 200;
                    if (PHOTO_CONFIG.mediaStream)
                    {
                        YTX_CONFIG.util.stopMediaStream(PHOTO_CONFIG.mediaStream);
                        PHOTO_CONFIG.mediaStream = null
                    }
                    if (PHOTO_CONFIG.video)
                    {
                        PHOTO_CONFIG.video = null
                    }
                    return resp
                }
            },
            audio: {
                apply: function (obj, onCanPlay, onError)
                {
                    AUDIO_CONFIG.state = 1;
                    var resp = {};
                    var userMedia = YTX_CONFIG.util.getUserMedia();
                    if (!userMedia)
                    {
                        resp.code = YTX_CONFIG._errcode._VOIP_NO_MEDIA;
                        resp.msg = "brower not support getUserMedia";
                        onError(resp);
                        return
                    }
                    var audio = null;
                    if (!!obj)
                    {
                        audio = obj.tag
                    }
                    function onErr(error)
                    {
                        var resp = {};
                        switch (error.code || error.name)
                        {
                            case'PERMISSION_DENIED':
                            case'PermissionDeniedError':
                                YTX_CONFIG._log(YTX_CONFIG._logLev._INFO, '用户拒绝提供信息。');
                                resp.msg = 'user refuesed';
                                break;
                            case'NOT_SUPPORTED_ERROR':
                            case'NotSupportedError':
                                YTX_CONFIG._log(YTX_CONFIG._logLev._INFO, '浏览器不支持硬件设备。');
                                resp.msg = 'brower not support';
                                break;
                            case'MANDATORY_UNSATISFIED_ERROR':
                            case'MandatoryUnsatisfiedError':
                                YTX_CONFIG._log(YTX_CONFIG._logLev._INFO, '无法发现指定的硬件设备。');
                                resp.msg = 'can not find device';
                                break;
                            default:
                                YTX_CONFIG._log(YTX_CONFIG._logLev._INFO, '无法打开麦克风。异常信息:' + (error.code || error.name));
                                resp.msg = 'can not open resource';
                                break
                        }
                        resp.code = YTX_CONFIG._errcode._VOIP_MEDIA_ERROR;
                        onError(resp)
                    }

                    userMedia.call(navigator, {audio: true}, function (stream)
                    {
                        if (AUDIO_CONFIG.state != 1)
                        {
                            YTX_CONFIG.util.stopMediaStream(stream);
                            return
                        }
                        var windowUrl = YTX_CONFIG.util.getWindowURL();
                        AUDIO_CONFIG.mediaStream = stream;
                        var rec = new HZRecorder(stream);
                        AUDIO_CONFIG.recorder = rec;
                        if (!!audio)
                        {
                            if (!!windowUrl)
                            {
                                audio.src = windowUrl.createObjectURL(stream)
                            }
                        }
                        else
                        {
                            audio = document.createElement("video");
                            if (!!windowUrl)
                            {
                                audio.src = windowUrl.createObjectURL(stream)
                            }
                        }
                        AUDIO_CONFIG.audio = audio;
                        if (onCanPlay && onCanPlay instanceof Function)
                        {
                            if (audio.addEventListener)
                            {
                                audio.addEventListener('canplay', function ()
                                {
                                    onCanPlay()
                                })
                            }
                            else if (audio.attachEvent)
                            {
                                audio.attachEvent('oncanplay', function ()
                                {
                                    onCanPlay()
                                })
                            }
                        }
                        rec.start(audio)
                    }, onErr)
                }, make: function ()
                {
                    var resp = {};
                    resp.code = 200;
                    if (!AUDIO_CONFIG.recorder)
                    {
                        resp.code = YTX_CONFIG._errcode._NO_RESOURCE_STREAM;
                        resp.msg = "please execute apply methord first";
                        return resp
                    }
                    var dataBlob = AUDIO_CONFIG.recorder.getBlob();
                    var windowUrl = YTX_CONFIG.util.getWindowURL();
                    var url = windowUrl.createObjectURL(dataBlob);
                    dataBlob.url = url;
                    var time = new Date().getTime();
                    dataBlob.fileName = time + ".wav";
                    resp.blob = dataBlob;
                    return resp
                }, cancel: function ()
                {
                    AUDIO_CONFIG.state = 2;
                    var resp = {};
                    resp.code = 200;
                    if (AUDIO_CONFIG.recorder)
                    {
                        AUDIO_CONFIG.recorder.stop();
                        AUDIO_CONFIG.recorder = null
                    }
                    if (AUDIO_CONFIG.audio)
                    {
                        AUDIO_CONFIG.audio = null
                    }
                    return resp
                }
            }
        };
    var PHOTO_CONFIG = {mediaStream: null, video: null, state: 1};
    var AUDIO_CONFIG = {audio: null, recorder: null, state: 1};
    var VIDEO_CONFIG = {};
    var HZRecorder = function (stream, config)
    {
        config = config || {};
        config.sampleBits = config.sampleBits || 8;
        config.sampleRate = config.sampleRate || (44100 / 6);
        var bufferLen = config.bufferLen || 4096;
        var numChannels = config.numChannels || 2;
        var context = new AudioContext();
        var audioInput = context.createMediaStreamSource(stream);
        var recorder = (context.createScriptProcessor || context.createJavaScriptNode).call(context, bufferLen, numChannels, numChannels);
        var audioData = {
            size: 0,
            buffer: [],
            inputSampleRate: context.sampleRate,
            inputSampleBits: 16,
            outputSampleRate: config.sampleRate,
            oututSampleBits: config.sampleBits,
            input: function (data)
            {
                this.buffer.push(new Float32Array(data));
                this.size += data.length
            },
            compress: function ()
            {
                var data = new Float32Array(this.size);
                var offset = 0;
                for (var i = 0; i < this.buffer.length; i++)
                {
                    data.set(this.buffer[i], offset);
                    offset += this.buffer[i].length
                }
                var compression = parseInt(this.inputSampleRate / this.outputSampleRate);
                var length = data.length / compression;
                var result = new Float32Array(parseInt(length));
                var index = 0, j = 0;
                while (index < length)
                {
                    result[index] = data[j];
                    j += compression;
                    index++
                }
                return result
            },
            encodeWAV: function ()
            {
                var sampleRate = Math.min(this.inputSampleRate, this.outputSampleRate);
                var sampleBits = Math.min(this.inputSampleBits, this.oututSampleBits);
                var bytes = this.compress();
                var dataLength = bytes.length * (sampleBits / 8);
                var buffer = new ArrayBuffer(44 + dataLength);
                var data = new DataView(buffer);
                var channelCount = 1;
                var offset = 0;
                var writeString = function (str)
                {
                    for (var i = 0; i < str.length; i++)
                    {
                        data.setUint8(offset + i, str.charCodeAt(i))
                    }
                };
                writeString('RIFF');
                offset += 4;
                data.setUint32(offset, 36 + dataLength, true);
                offset += 4;
                writeString('WAVE');
                offset += 4;
                writeString('fmt ');
                offset += 4;
                data.setUint32(offset, 16, true);
                offset += 4;
                data.setUint16(offset, 1, true);
                offset += 2;
                data.setUint16(offset, channelCount, true);
                offset += 2;
                data.setUint32(offset, sampleRate, true);
                offset += 4;
                data.setUint32(offset, channelCount * sampleRate * (sampleBits / 8), true);
                offset += 4;
                data.setUint16(offset, channelCount * (sampleBits / 8), true);
                offset += 2;
                data.setUint16(offset, sampleBits, true);
                offset += 2;
                writeString('data');
                offset += 4;
                data.setUint32(offset, dataLength, true);
                offset += 4;
                if (sampleBits === 8)
                {
                    for (var i = 0; i < bytes.length; i++, offset++)
                    {
                        var s = Math.max(-1, Math.min(1, bytes[i]));
                        var val = s < 0 ? s * 0x8000 : s * 0x7FFF;
                        val = parseInt(255 / (65535 / (val + 32768)));
                        data.setInt8(offset, val, true)
                    }
                }
                else
                {
                    for (var i = 0; i < bytes.length; i++, offset += 2)
                    {
                        var s = Math.max(-1, Math.min(1, bytes[i]));
                        data.setInt16(offset, s < 0 ? s * 0x8000 : s * 0x7FFF, true)
                    }
                }
                return new Blob([data], {type: 'audio/wav'})
            }
        };
        this.start = function (obj)
        {
            audioInput.connect(recorder);
            recorder.connect(context.destination);
            var windowUrl = YTX_CONFIG.util.getWindowURL();
            if (!!obj && !!windowUrl)
            {
                var url = windowUrl.createObjectURL(stream);
                obj.src = url
            }
        }, this.stop = function ()
        {
            recorder.disconnect();
            YTX_CONFIG.util.stopMediaStream(stream)
        }, this.getBlob = function ()
        {
            this.stop();
            return audioData.encodeWAV()
        }, this.play = function (audio)
        {
            var windowUrl = YTX_CONFIG.util.getWindowURL();
            audio.src = windowUrl.createObjectURL(this.getBlob())
        }, recorder.onaudioprocess = function (e)
        {
            audioData.input(e.inputBuffer.getChannelData(0))
        }
    };
    HZRecorder.throwError = function (message)
    {
        throw new function ()
        {
            this.toString = function ()
            {
                return message;
            }
        }
    };
    HZRecorder.get = function (callback, config)
    {
        if (callback)
        {
            var userMedia = YTX_CONFIG.util.getUserMedia();
            if (userMedia)
            {
                if (HZRecorder.recorderIndex == 0)
                {
                    HZRecorder.recorderIndex = 1;
                    userMedia({audio: true}, function (stream)
                    {
                        var rec = new HZRecorder(stream, config);
                        callback(rec);
                        HZRecorder.recorderIndex = 0
                    }, function (error)
                    {
                        switch (error.code || error.name)
                        {
                            case'PERMISSION_DENIED':
                            case'PermissionDeniedError':
                                HZRecorder.throwError('用户拒绝提供信息。');
                                break;
                            case'NOT_SUPPORTED_ERROR':
                            case'NotSupportedError':
                                HZRecorder.throwError('浏览器不支持硬件设备。');
                                break;
                            case'MANDATORY_UNSATISFIED_ERROR':
                            case'MandatoryUnsatisfiedError':
                                HZRecorder.throwError('无法发现指定的硬件设备。');
                                break;
                            default:
                                HZRecorder.throwError('无法打开麦克风。异常信息:' + (error.code || error.name));
                                break
                        }
                        HZRecorder.recorderIndex = 0
                    })
                }
            }
            else
            {
                HZRecorder.throwError('当前浏览器不支持录音功能。');
                return
            }
        }
    };
    window.HZRecorder = HZRecorder;
    String.prototype.startWith = function (str)
    {
        if (str == null || str == "" || this.length == 0 || str.length > this.length)
        {
            return false;
        }
        if (this.substr(0, str.length) == str)
        {
            return true;
        }
        else
        {
            return false;
        }
        return true
    };
    String.prototype.endWith = function (str)
    {
        if (str == null || str == "" || this.length == 0 || str.length > this.length)
        {
            ;
        }
        return false;
        if (this.substring(this.length - str.length) == str)
        {
            return true;
        }
        else
        {
            return false;
        }
        return true
    }
})();
