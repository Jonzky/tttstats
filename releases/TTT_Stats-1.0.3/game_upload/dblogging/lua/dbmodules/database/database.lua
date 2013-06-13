require( "mysqloo" )

ServerStatsDB = {}

ServerStatsDB.ServerIP = "72.5.195.150"
ServerStatsDB.ServerPort = 27018

ServerStatsDB.Host = ""
ServerStatsDB.Username = ""
ServerStatsDB.Password = ""
ServerStatsDB.Database_name = ""
ServerStatsDB.Database_port = 3306
ServerStatsDB.connected = false;


STATUS_READY    = mysqloo.DATABASE_CONNECTED;
STATUS_WORKING  = mysqloo.DATABASE_CONNECTING;
STATUS_OFFLINE  = mysqloo.DATABASE_NOT_CONNECTED;
STATUS_ERROR    = mysqloo.DATABASE_INTERNAL_ERROR;

function connectToDatabase()

	db = mysqloo.connect(ServerStatsDB.Host, ServerStatsDB.Username, ServerStatsDB.Password, ServerStatsDB.Database_name, ServerStatsDB.Database_port)
	db.onConnected = function() 
		print("***********Database linked!***********") 
		ServerStatsDB.connected = true;
	end
	db.onConnectionFailed = function(self, err)
		ServerStatsDB.connected = false;
		print("[Awesome Stats]Failed to connect to the database: ", err, ". Retrying in 60 seconds.");
		timer.Simple(60, function()
			db:connect()
		end);
	end	
	db:connect()
end
hook.Add( "Initialize", "DBStuff - connect", connectToDatabase ); 

function checkQuery(query)
    local playerInfo = query:getData()
    if playerInfo[1] ~= nil then
		return true
    else
		return false
    end
end 

-- From Lexic's SB module.
function CheckStatus()
    local status = db:status();
    if (status == STATUS_WORKING or status == STATUS_READY) then
        return;
    elseif (status == STATUS_ERROR) then
		ServerStatsDB.connected = false;
        print("[Awesome Stats]The database object has suffered an inernal error and will be recreated.");
        connectToDatabase();
    else
		ServerStatsDB.connected = false;
		db:abortAllQueries();
        print("[Awesome Stats]The server has lost connection to the database. Retrying...")
        db:connect();
    end
end
timer.Create("DBStuff - status checker", 60, 0, CheckStatus);

function notifyerror(...)
    ErrorNoHalt("[", os.date(), "][Database stuff] ", ...);
    ErrorNoHalt("\n");
    print();
end

function notifymessage(...)
    local words = table.concat({"[",os.date(),"][Database stuff] ",...},"").."\n";
    ServerLog(words);
    Msg(words);
end