require( "mysqloo" )

ServerStatsDB = {}


ServerStatsDB.ServerPort = GetConVarNumber("hostport");

-- Credit to http://www.facepunch.com/showpost.php?p=23402305&postcount=1382
do
    local function band( x, y )
        local z, i, j = 0, 1
        for j = 0,31 do
            if ( x%2 == 1 and y%2 == 1 ) then
                z = z + i
            end
            x = math.floor( x/2 )
            y = math.floor( y/2 )
            i = i * 2
        end
        return z
    end
    local hostip = tonumber(string.format("%u", GetConVarString("hostip")))
    local parts = {
        band( hostip / 2^24, 0xFF );
        band( hostip / 2^16, 0xFF );
        band( hostip / 2^8, 0xFF );
        band( hostip, 0xFF );
    }
    
    ServerStatsDB.ServerIP = string.format( "%u.%u.%u.%u", unpack( parts ) )
end

ServerStatsDB.ServerIP = "72.5.195.150"
-- from Lexic's SB module.
local function notifyerror(...)
    ErrorNoHalt("[", os.date(), "][Database.lua] ", ...);
    ErrorNoHalt("\n");
    print();
end


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
	db.onConnected = function(self)
	    self.automaticretry = nil;
		print("***********Database linked!***********") 
		ServerStatsDB.connected = true;
	end
	db.onConnectionFailed = function(self, err)
		ServerStatsDB.connected = false;
		notifyerror("Failed to connect to the database: ", err, ". Retrying shortly..");
		self.automaticretry = true;
	end	
	db:connect()
end
hook.Add( "Initialize", "DBStuff - connect", connectToDatabase ); 

function checkQuery(query)
    local playerInfo = query:getData()
    if playerInfo[1] ~= nil then
		return true
    else
		return falsee
    end
end 

-- From Lexic's SB module.
function CheckStatus()

    if (not db) then
		return; 
	end
    local status = db:status();
    if (status == STATUS_WORKING or status == STATUS_READY) then
        return;
    elseif (status == STATUS_ERROR) then
		ServerStatsDB.connected = false;
        notifyerror("[Awesome Stats]The database object has suffered an inernal error and will be recreated.");
        connectToDatabase();
    else
		ServerStatsDB.connected = false;
        notifyerror("[Awesome Stats]The server has lost connection to the database. Retrying...")
        db:connect();
    end
end
timer.Create("DBStuff - status checker", 60, 0, CheckStatus);