require( "mysqloo" )

AddCSLuaFile( "cl_dermastuff.lua" )
include( "cl_dermastuff.lua" )
include("serverTrack.lua")
include("Statstest.lua")

ServerStatsDB = {}

ServerStatsDB.ServerIP = "192.168.0.9"
ServerStatsDB.ServerPort = 27015

ServerStatsDB.Host = "50.116.87.115"
ServerStatsDB.Username = "jonzky_jonzky"
ServerStatsDB.Password = "123spam123"
ServerStatsDB.Database_name = "jonzky_sb"
ServerStatsDB.Database_port = 3306


STATUS_READY    = mysqloo.DATABASE_CONNECTED;
STATUS_WORKING  = mysqloo.DATABASE_CONNECTING;
STATUS_OFFLINE  = mysqloo.DATABASE_NOT_CONNECTED;
STATUS_ERROR    = mysqloo.DATABASE_INTERNAL_ERROR;

function connectToDatabase()

	db = mysqloo.connect(ServerStatsDB.Host, ServerStatsDB.Username, ServerStatsDB.Password, ServerStatsDB.Database_name, ServerStatsDB.Database_port)
	db.onConnected = function() 
		print("[Awesome Stats]******************Database linked!******************************") 
		databaseFailed = false;
		loadServerStats();
	end
	db.onConnectionFailed = function(self, err)
		databaseFailed = true;
		print("[Awesome Stats]Failed to connect to the database: ", err, ". Retrying in 60 seconds.");
		timer.Simple(60, self.connect, self);
	end
	db:connect()
end
hook.Add( "Initialize", "connectToDatabase111", connectToDatabase ); 

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
		databaseFailed = true;
        print("[Awesome Stats]The database object has suffered an inernal error and will be recreated.");
        connectToDatabase();
    else
		databaseFailed = true;
		db:abortAllQueries();
        print("[Awesome Stats]The server has lost connection to the database. Retrying...")
        db:connect();
    end
end
timer.Create("TTTstatschecker", 60, 0, CheckStatus);