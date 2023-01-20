INSERT INTO `ubu` (`item`) VALUES
('Enable hidden files and file extensions in file system view options <a href="#filesystem">File System</a>'),
('Enable the UCF firewall <a href="#network">Network Security</a>'),
('System Software &amp; Updates (START SYSTEM UPDATES) <a href="#software">System Updates &amp; Software</a>'),
('EVALUATE THE FORENSIC QUESTIONS
    Forensic question generally asks for a directory where an unauthorized file or user was found. Check FORENSICS before removing anything!
    DON\'T get bogged down in the forensics, but be careful not to delete evidence!'),
(' SAVE EVIDENCE. If a file, immediately make a copy of the forensic file and place on the host system so we don\t forget
	    Note: if you are dealing with <strong>encryption/encoding/stegonography/hash</strong>, look in the related section in the <u>General Tips</u> sheet.'),
('Reconcile authorized users (cat /etc/passwd)'),
('		create a text file containing authorized users from the README'),
('		Remove unauthorized users <a href="#lusrmgr">Local User Management</a>'),
('		Add any missing authorized users and home dir <a href="#lusrmgr">Local User Management</a> (BUT do your forensics first!)'),
('		Remove non-admins from admin group/set them to standard user <a href="#lusrmgr">Local User Management</a>'),
('Look for unauthorized file shares (see file system section) <a href="#filesystem">File System</a> (check the README and Forensics first)'),
('Check file permissions <a href="#filesystem">File System</a> (read your readme file!!!!)'),
(' Run bash script on Ubuntu
    * Set secure passwords on user accounts.  Use our "BoiseBee#1" and be consistent.
    <a href="linux_script.sh" download="linux_script.sh">Download</a> <strong>RIGHT CLICK ON LINK AND PRESS SAVE LINK AS(IF NO DOWNLOAD)</strong> '),
('Policy <a href="#secpol">Security Policy</a>'),
('Update the default browser as indicated in the README file (e.g. Firefox) <a href="#browser">Browser Settings</a>'),
('		Firefox pop-up blocker enabled'),
('		Firefox automatically installs updates'),
('Remove unsanctioned and unwanted programs.  Programs and Features/Software center <a href="#software">System Updates &amp; Software</a>'),
('Stop and disable unauthorized services <a href="#services">Services &amp; Processes</a>
    o run netstat -ant and check for listening services.  Check your services file to see what ports map to what services
        Linux: /etc/services'),
('Remove unauthorized files (mp3, m4b, .aa, .mkv, .m4r) (did you do forensics first?!) <a href="#filesystem">File System</a>'),
('Remove hacking tools (nmap, rainbowcrack, ophcrack,*crack*, xhydra, wireshark, openvpn, betternetVPN, *sploit*) (did you do forensics first?!) <a href="#filesystem">File System</a>'),
('Set remote access related settings (openSSH) defined in README (see policy section) <a href="#secpol">Security Policy</a>'),
('<a href="LinuxChecklist.txt">Other Checklist and useful commands</a>');