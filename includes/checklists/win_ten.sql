INSERT INTO `win_ten` (`item`) VALUES
('Enable hidden files and file extensions in file system view options <a href=\"#filesystem\">File System</a>'),
('Enable the firewall <a href=\"#network\">Network Security</a>'),
('Enable/verify antivirus is running <a href=\"#gpo\">Global Domain Policy</a>'),
('Enable/verify that Windows Event Log service is running (services.msc) <a href=\"#services\">Services & Processes</a>'),
('Enable/verify Windows Update service/Software Updates are running.  (START SYSTEM UPDATES) <a href=\"#software\">System Updates &amp; Software</a>'),
('EVALUATE THE FORENSIC QUESTIONS\r\n        
	Forensic question generally asks for a directory where an unauthorized file or user was found. 
	Check FORENSICS before removing anything!\r\n        
	DON\'T get bogged down in the forensics, but be careful not to delete evidence!'),
('SAVE EVIDENCE. If a file, immediately make a copy of the forensic file and place on the host system so we don\'t forget'),
('create a text file containing authorized users from the README'),
('Remove unauthorized users <a href=\"#lusrmgr\">Local User Management</a>'),
('Add any missing authorized users <a href=\"#lusrmgr\">Local User Management</a>'),
('Remove non-admins from admin group/set them to standard user <a href=\"#lusrmgr\">Local User Management</a>'),
('Reconcile authorized users (lusrmgr.msc)'),
('Remove unauthorized user directories c:\users or /home (BUT do your forensics first!) <a href="#filesystem">File System</a>'),
('Look for unauthorized file shares (check the README and Forensics first) <a href="#filesystem">File System</a>'),
('Check file permissions (read your readme file!!!!) <a href="#filesystem">File System</a>'),
('Run CP_winscript.ps1 on Windows (PowerShell run as administrator)
	<a href="CP_winscript.ps1" download="CP_winscript.ps1">Download CP_winscript.ps1</a> <strong>RIGHT CLICK ON LINK AND PRESS SAVE LINK AS(IF NO DOWNLOAD</strong> 
	<a href="LGPO.exe" download="LGPO.exe">Download LGPO.exe</a> <strong> RIGHT CLICK ON LINK AND PRESS SAVE LINK AS (IF NO DOWNLOAD)</strong>
	<a href="GptTmpl.inf" download="GptTmpl.inf">Download GptTmpl.inf</a> <strong>RIGHT CLICK ON LINK AND PRESS SAVE LINK AS(IF NO DOWNLOAD</strong>'),
('Run the <strong>"lgpo.exe /s GptTmpl.inf"</strong> import '),
('Group Policy <a href="#gpo">Global Domain Policy</a>'),
('Update the default browser as indicated in the README file (e.g. Firefox) <a href="#browser">Browser Settings</a>'),
('      Firefox pop-up blocker enabled'),
('		Firefox automatically installs updates'),
('Update all required, valid software to latest version as defined in README'),
('Remove unsanctioned and unwanted programs. <a href="#software">System Updates &amp; Software</a>'),
('Stop and disable unauthorized services
    o run netstat -ant and check for listening services.  
	  Check your services file to see what ports map to what services
           Win: C:\Windows\System32\drivers\etc\services'),
('Remove unauthorized files (mp3, m4b, .aa, .mkv, .m4r) (did you do forensics first?!)'),
('Remove hacking tools (nmap, rainbowcrack, ophcrack,*crack*, xhydra, wireshark, openvpn, betternetVPN, *sploit*) (did you do forensics first?!)'),
('Set remote access related settings (RDP, openSSH) defined in README');