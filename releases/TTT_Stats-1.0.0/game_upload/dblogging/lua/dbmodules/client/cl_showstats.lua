
function showStats(len)

	rPly = net.ReadEntity();
	steamid = rPly:SteamID64()
	print(steamid)
	local url = string.format("http://thehiddennation.com/ttt_stats/motd.php?steamid=%s", steamid)
	print(url)
	local window = vgui.Create( "DFrame" )
	if ScrW() > 640 then
		window:SetSize( ScrW()*0.9, ScrH()*0.9 )
	else
		window:SetSize( 640, 480 )
	end
	window:Center()
	window:SetTitle( "Awesome Stats!" )
	window:SetVisible( true )
	window:MakePopup()
	window:ShowCloseButton(false)
	window:SetDraggable(false)

	local html = vgui.Create( "HTML", window )

	local button = vgui.Create( "DButton", window )
	button:SetText( "Close" )
	button.DoClick = function() window:Close() end
	button:SetSize( 150, 40 )
	button:SetDisabled(false)
	
	button:SetPos( ((window:GetWide() - button:GetWide()) / 2), window:GetTall() - button:GetTall() - 10 )
	html:SetSize( window:GetWide() - 20, window:GetTall() - button:GetTall() - 50 )
	html:SetPos( 10, 30 )
	
	html:OpenURL( url )

end
net.Receive( "Staty", showStats)

