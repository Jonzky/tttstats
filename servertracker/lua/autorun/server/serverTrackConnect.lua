require( "mysqloo" )
---- UPDATE ME
SERVER_IP = "localhost"
SERVER_PORT = 27015
MAX_PLAYERS = 18

STATUS_READY    = mysqloo.DATABASE_CONNECTED;
STATUS_WORKING  = mysqloo.DATABASE_CONNECTING;
STATUS_OFFLINE  = mysqloo.DATABASE_NOT_CONNECTED;
STATUS_ERROR    = mysqloo.DATABASE_INTERNAL_ERROR;


local DATABASE_HOST = "50.116.87.115"
local DATABASE_PORT = 3306
local DATABASE_NAME = "jonzky_sb"
local DATABASE_USERNAME = "jonzky_jonzky"
local DATABASE_PASSWORD = "123spam123"

function connectToDatabase()

	db = mysqloo.connect(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME, DATABASE_PORT)
	db.onConnected = function() 
		print("[Awesome Tracker]******************Database linked!******************************") 
	    automaticretry = nil;
		databaseFailed = false;
		loadServerStats();
	end
	db.onConnectionFailed = function(self, err)
		databaseFailed = true;
		print("[Awesome Tracker]Failed to connect to the database: ", err, ". Retrying in 60 seconds.");
		automaticretry = true;	
		timer.Simple(60, self.connect, self);
	end
	db:connect()
end
hook.Add( "Initialize", "connectToDatabaseServerT", connectToDatabase ); 
 
 
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
    if (not db or automaticretry) then return; end
    local status = db:status();
    if (status == STATUS_WORKING or status == STATUS_READY) then
        return;
    elseif (status == STATUS_ERROR) then
        print("[Awesome Tracker]The database object has suffered an inernal error and will be recreated.");
        connectToDatabase();
    else
		print(status);
		db:abortAllQueries();
        print("[Awesome Tracker]The server has lost connection to the database. Retrying...")
        db:connect();
    end
end
timer.Create("Servberstatschecker", 60, 0, CheckStatus);
