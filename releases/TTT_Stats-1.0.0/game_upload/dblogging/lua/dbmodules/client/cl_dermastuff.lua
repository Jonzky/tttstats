if(CLIENT) then

	function makeStuff (len)
	
		local DermaPanel = vgui.Create( "DFrame" )
		DermaPanel:SetPos( ScrW()/2-250, ScrH()/2-250 )
		DermaPanel:SetSize( 720, 355 )
		DermaPanel:SetTitle( "TTT stats Server Browser:" )
		DermaPanel:SetVisible( true )
		DermaPanel:SetDraggable( true )
		DermaPanel:ShowCloseButton( true )
		DermaPanel:MakePopup()
		
		DermaList = vgui.Create( "DPanelList", DermaPanel )
		DermaList:SetPos( 5,25 )
		DermaList:SetSize( 700, 325 )
		DermaList:SetSpacing( 1 )
		DermaList:EnableHorizontal( false )
		DermaList:EnableVerticalScrollbar( true ) 		
		
		local data = net.ReadTable()
		for id, row in pairs( data ) do
			local texty = string.format("Connect to: %s - Current map %s - Current playercount %d/%d", row['hostname'], row['map'], row['players'], row['maxplayers'])
			local dButton = vgui.Create( "DButton", DermaList )
			dButton:SetText( texty )
			dButton:SetSize( 700, 30 )
			dButton.DoClick = function ()
				local strHost = tostring(row['hostip'] )
				print("*" .. strHost .. "*")
				LocalPlayer():ConCommand( "connect " .. strHost )
			end
			DermaList:AddItem(dButton)
		end
	end 
	net.Receive( "TESTY", makeStuff)
	
end	