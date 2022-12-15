    <!DOCTYPE html>
    <html>
        <head>
            <title>Boise CP Webpage</title>
            <script src = "App.js" defer></script>
            <link rel="stylesheet" href="style.css">
        </head>
        <body>
            <div class="dropdown">
                <button class = "dropbtn">CHOOSE YOUR OS</button>
                <div class="dropdown-content">
                <a href="Windows10/windows10.php" target="_blank">Windows 10</a>
                <a href="WindowsServer/windowsServer.php" target="_blank">Windows Server</a>
                <a href="Ubuntu/Ubuntu.php" target="_blank">Ubuntu</a>
                <a href="Cisco/cap_cisco_tips.php" target="_blank">Cisco</a>
                </div>
            </div>
            <br>
            <br>
            <br>
            <br>
            
            



            <div class ="General">
                Last updated: Nov/2022
                
                <h1>Cyberpatriot XIV 2022 Team Info</h1>
                
                <strong>HIGH SCHOOL TEAM 15-2268</strong></br>
                Unique Team ID: <b style="color:Tomato;">3VUF-LJV2-BFKB</b></br>
                Boise Composite Squadron,a CAP</br>
                Boise Bee's</br>
                Civil Air Patrol - High School</br>
                cpxv.net152268@gmail.com</br>
                Password:  3VUF-LJV2-BFKBcp15</br>
                </br>
                <b>JUNIOR HIGH 15-2269</b></br>
                Unique Team ID: <b style="color:Tomato;">TV27-DHTH-T87G</b></br>
                cpxv.net152269@gmail.com</br>
                Password: TV27-DHTH-T87Gcp15</br>
                </br>
                <b>Cisco NetAcad Training</b></br>
                Username:  kenneth.mcconnell@capboise.org</br>
                Password:  JoulesRouse#42</br>
                
                <p>
                2022 CP 15 State Round Image <strong style="color:Tomato;">extraction password: TBD</strong></br> 
                </p>
                <h2 id="toc">Table of Contents</a></h2>
                <h2>TOC</h2>
                <a href="#General Rules">General Rules</a></br>
                <a href="#Comptips">Competition tips</a></br>
                <a href="#scored">Previously Scored Items</a></br>
                <a href="#bitsandbytes">Bits and Bytes</a></br>
                <a href="#encoding">Encoding/Encryption/Hash/Stegonography</a></br>
                <a href="#yara">YARA</a></br>
                <a href="#regex">Regular Expressions</a></br>
                <a href="#coding">Coding</a></br>
                
                <h2 id="General Rules">General Rules</h2>
                
                <ul>
                <li>Don’t eat and work (don’t mess up the computers)
                <li>Stay focused.  Don’t get sidetracked with irrelevant tasks.
                <li>Even if you’re done with your task, don’t distract the rest of the team.
                <li>Not all vulnerabilities are scored or hinted at in the Readme.</br> 
                  The goal of the competition is to harden the system as completely as possible in the provided time.</br> 
                  You might do something that improves the system, but does not earn your team points...that's OK.</br>
                <li>Don't grab the keyboard and mouse from someone when they are driving.  Make suggestions but don't just take over!
                <li>Focus on the one image you are assigned until you reach a point of diminishing returns and be willing to hand over if your stuck. 
                <li>Work as a team!
                </ul>
                <a href="#toc">back to toc</a></br>
                <h2 id="Comptips">Competition tips</h2>
                <p>
                Order of events
                <ul>
                <li> START PATCHES AND UPDATES process on guest VM, NOT your host system!  
                <li> While updates are running, review the competition README file and discuss methods to address the issues. Whiteboard ideas.
                <li> DO FORENSICS early to avoid removing evidence with others actions.
                <li> Continually review the README!  Reconcile the readme to the scorecard.  Be sure to address each item that is called out on the readme.  
                <li> Cover the basics... e.g. passwords, group memberships, audit policy, firewall, antivirus etc.  Try to "bank" as many points as you can!
                <li> Develop a schedule (define an interval for group discussion, when do we stop to eat ~ 45 min or so?) all on one image at a specific time, etc?)  Stages?
                <li> Define the time you want/need break.  If mid-competition, remember the clock is ticking. If you're burnt out, swap images.
                <li> Refer to the tips sheets files often! Keep building a checklist, take notes as things come to mind and we will add to checklist as we learn.
                <li> Remember you can "google" for answers.  Often you can find tips for forensics questions just by searching the forensic question text.
                </ul>
                </p>
                <a href="#toc">back to toc</a></br>
                <h2 id="scored">Previously Scored Items</h2>
                <p>
                Windows 10 image
                <ul>
                <li> Forensics Question 1 correct - 8 pts
                <li> Forensics Question 2 correct - 8 pts
                <li> Forensics Question 3 correct - 8 pts
                <li> Removed unauthorized user teka - 4 pts
                <li> Removed unauthorized user tamatoa - 4 pts
                <li> User xyz account created
                <li> User pua is not an administrator - 4 pts
                <li> User tui is not an administrator - 4 pts
                <li> Changed insecure password for maui - 4 pts
                <li> A sufficient password history is being kept - 4 pts
                <li> A secure lockout threshold exists - 4 pts
                <li> Firewall protection has been enabled - 5 pts
                <li> File sharing disabled for C drive - 5 pts
                <li> World Wide Web Publishing service has been stopped and disabled - 5 pts
                <li> The majority of Windows updates are installed - 5 pts
                <li> Firefox has been updated - 5 pts
                <li> Notepad++ has been updated - 5 pts
                <li> Removed prohibited MP3 files - 5 pts
                <li> Removed Wireshark - 4 pts
                <li> Removed MyCleanPC - 4 pts
                <li> Require ctrl-alt-del for login
                <li> Windows Update service enabled
                <li> Windows Defender Antivirus enabled
                <li> RDP network level authentication enabled
                </ul>
                </p>
                <p>
                Windows Server
                <ul>
                <li> Forensics Question 1 correct - 12 pts
                <li> Forensics Question 2 correct - 12 pts
                <li> Removed unauthorized user ancano - 5 pts
                <li> Removed unauthorized user tolfdir - 5 pts
                <li> User lydia is not an administrator - 5 pts
                <li> User balgruuf has a password - 5 pts
                <li> A secure maximum password age exists - 6 pts
                <li> A secure lockout threshold exists - 6 pts
                <li> Limit local use of blank passwords to console only [enabled] - 6 pts
                <li> File share greybeard disabled - 6 pts
                <li> FTP service has been stopped and disabled - 6 pts
                <li> Firefox has been updated - 6 pts
                <li> Firefox automatically installs updates - 5 pts
                <li> Removed BitTorrent - 5 pts
                <li> Removed Wireshark - 5 pts
                <li> Removed Adaware WebCompanion - 5 pts
                </ul>
                </p>
                <p>
                Ubuntu 14 image
                <ul>
                <li> Forensics Question 1 correct - 8 pts
                <li> Forensics Question 2 correct - 8 pts
                <li> Forensics Question 3 correct - 8 pts
                <li> Removed unauthorized user brainiac - 4 pts
                <li> Removed unauthorized user alchemy - 4 pts
                <li> User wwest is not an administrator - 4 pts
                <li> User jwest is not an administrator - 4 pts
                <li> Changed insecure password for user jwells - 4 pts
                <li> A default maximum password age is set - 5 pts
                <li> Uncomplicated Firewall (UFW) protection has been enabled - 6 pts
                <li> OpenSSH service has been installed and started - 5 pts
                <li> Samba service has been disabled or removed - 5 pts
                <li> The system automatically checks for updates daily - 4 pts
                <li> Linux kernel has been updated - 4 pts
                <li> Sudo has been updated - 4 pts
                <li> Firefox has been updated - 4 pts
                <li> Prohibited MP3 files are removed - 4 pts
                <li> Prohibited software ophcrack removed - 5 pts
                <li> Prohibited software Minetest removed - 5 pts
                <li> SSH root login has been disabled - 5 pts
                <li> Prohibited software FreeCiv removed
                <li> Firefox pop-up blocker enabled
                <li> Prohibited software Zenmap and Nmap removed
                <li> Firewall protection has been enabled
                </ul>
                </p>
                <a href="#toc">back to toc</a></br>
                <h2 id="bitsandbytes">Bits and Bytes</h2>
                <pre>
                Bits &amp; Bytes
                    1 bit = nibble
                    8 bits per byte
                    K = Kilo = 1,000
                    M = Meg  = 1,000,000
                    G = Gig  = 1,000,000,000
                    T = Tera = 1,000,000,000,000
                    P = Peta = 1,000,000,000,000,000
                        1 KB = 1,000 bytes
                        1,000 bytes = 1,000(8 bits per byte) = 8,000 bits
                        1,024 bytes = 1,024(8 bits per byte) = 8,192 bits
                </pre>
                <a href="#toc">back to toc</a></br>
                <h2 id="encoding">Encoding/Encryption/Hash/Stegonography</h2>
                <pre>
                <a href="https://gchq.github.io/CyberChef/" target="_blank">CyberChef</a> multi-technique decode/decrypt/hash tool
                    
                File hash
                  (Win Powershell) Get-FileHash  &lt;filename&gt; -Algorithm (md5 | sha1 | sha256)
                  (Ubuntu) sha1sum {file} or md5sum {file}
                
                Base64 is an encoding format that can encode any binary data to a string consisting of 64 base characters. Base64 encoded data will always have the following characteristic:
                    o The length of a Base64-encoded string is always a multiple of 4
                    o Only these characters are used by the encryption: “A” to “Z”, “a” to “z”, “0” to “9”, “+” and “/”
                    o The end of a string can be padded up to two times using the “=”-character (this character is allowed in the end only)
                    
                    # Note how the number of bytes in the encoded string is padded to a certain length
                        1 --&gt; MQ== 
                        12 --&gt; MTI=   
                        123 --&gt; MTIz
                        1234 --&gt; MTIzNA==
                        12345  --&gt; MTIzNDU=
                        123456  --&gt; MTIzNDU2
                    
                       Example: U29tZXRoaW5nIHRvIGRlY29kZSA=
                
                Windows Powershell Base64 encode/decode (easier to use CyberChef)
                   [Convert]::ToBase64String([System.Text.Encoding]::ASCII.GetBytes("test"))
                   [System.Text.Encoding]::ASCII.GetString([Convert]::FromBase64String("dGVzdA=="))
                
                Ubuntu Base64 
                    decode
                      base64 -d
                      cat &lt;file&gt; | base64 -d
                    
                    encode
                      echo -n 'stringToEncode' | base64 -w0
                        -n ensures not to append a new line \n to the string
                        base64 -w0 disables adding a newline character if the string is too long.
                    
                ROT13 - Rotates characters by 13 positions.  A ROT cipher can be any number e.g. ROT5, ROT18 (numbers or letters). ROT47 (includes all ASCII characters).
                        It will look like a sentence, just jumbled. 
                        
                        Example: Fbzrguvat gb qrpbqr
                        
                Stegonography - Find message hidden in an image
                  Steghide can be used to hide messages in images.  It is available on Linux and Windows
                    Linux: sudo apt-get install steghide
                    Windows: http://steghide.sourceforge.net/download.php
                        http://steghide.sourceforge.net/documentation.php
                 
                    The basic usage is as follows:
                
                    $ steghide embed -cf picture.jpg -ef secret.txt
                    Enter passphrase:&lt;optional&gt;
                    Re-Enter passphrase:
                    embedding "secret.txt" in "picture.jpg"... done
                
                    This command above will embed the file secret.txt in the cover file picture.jpg.
                    After you have embedded your secret data as shown above you can send the file picture.jpg to the person who should receive the secret message. The receiver has to use steghide in the following way:
                
                    $ steghide extract -sf picture.jpg
                    Enter passphrase:
                    wrote extracted data to "secret.txt".
                
                    If the supplied passphrase is correct, the contents of the original file secret.txt will be extracted from the stego file picture.jpg and saved in the current directory.
                  
                File content obfuscation:
                  A file archived with 7zip, then that file is encoded with base64. Reverse the process to see content.
                    o observe the first few characters of the decode output or open the saved file in notepad and look for the magic byte (e.g. 7z)
                    o open the file in the appropriate application (e.g. 7zip)
                
                For a file encrypted with Pretty Good Privacy (PGP) or GNU Privacy Guard (gpg).  Download utility from:
                https://www.gpg4win.org
                
                Reverse the order of a string: https://www.convertstring.com/StringFunction/ReverseString
                
                </pre>       
                <a href="#toc">back to toc</a></br>
                <h2 id="yara">YARA</H2>
                <PRE>
                What is YARA?
                YARA is a tool that identifies malware by creating descriptions that look for certain characteristics. Each description can be either a text or a binary pattern. These descriptions are called “rules”. And by using rules that specify regex (regular expressions) patterns, YARA enables the detection of specific patterns in files that might indicate that the file is malicious.
                
                By using hex patterns, plain text patterns, wild-cards, case-insensitive strings, and special operators, YARA rules can be incredibly diverse and effective at detecting a wide range of malware signatures.
                
                Example file
                
                rule ExampleRule
                {
                    strings:
                        $my_text_string = "malware_by_Hax0r"
                 
                    condition:
                        $my_text_string
                }
                
                
                YARA's official documentation here:https://yara.readthedocs.io/en/latest/)
                </PRE>
                <a href="#toc">back to toc</a></br>
                <h2 id="regex">Regular Expressions</h2>
                <pre>
                A regular expression (shortened as regex or regexp) is a sequence of characters that specifies a search pattern. 
                
                Reference:
                
                regex101.com - test your regex
                regexone.com - More exercises
                regexcrossword.com - Learn regex through solving crossword puzzles
                rexegg.com - A lot of information about regular expressions
                https://en.wikipedia.org/wiki/Regular_expression
                
                  \w = 0-9, A-Z, a-z any alpanumeric character
                  \W = any non-alphanumeric character
                  \d = 0-9 any digit
                  \D = any non-digit
                  . = any character
                  \s = whitespace
                  \S = any non-whitespace 
                
                  (abc|def) Matches abc or def
                  [a-z] Characters a to z
                  [0-9] Numbers 0 to 9
                
                Syntax follows a certain structure. Here's a list of the basic special characters you need to know:
                
                / : All regexes are enclosed within forward slashes to indicate where they begin and where they end.
                ^ : The circumflex accent matches the beginning of the string or the beginning of the line. This means your pattern will not match anything that has any text before it. Example: /^Once upon a time/ will match any line beginning with that sentence.
                $ : The dollar sign matches the end of the string. The opposite of the ^. Example: /ation$/ will match any line ending with the string "ation".
                [] : Brackets are used to match a single character from the list enclosed in them. For example, /[abc]/ This will match either a, b or c. Regexes accept ranges of letters as well, such as a-z or d-m, and even several ranges like [a-f0-6] (a to f and zero to 6).
                * : An asterisk acts as a quantifier to specify that the preceding character may appear 0 to n times. Example: /[ab]\*/ will match abab, aaaaaaa, but it will also match an empty string.
                + : A plus sign is similar to *, except that the preceding character has to appear at least once, meaning it will match the same strings as the previous example, except for the empty string.
                {}: The braces are used when you want to specify the number of times the preceding character should appear. Writing a single number within braces will match the strings that contain the preceding character or pattern that exact amount of times. Braces can also include ranges. If you want a string that contains 4 to 8 characters, you can use {4,8} to validate it.
                
                Practical example of a regular expression to define private IP ranges:
                var privateIP = /^(0|10|127|192\.168|172\.1[6789]|172\.2[0-9]|172\.3[01]|169\.254)\.[0-9.]+$/;
                
                matches a string that contains only loweer case letters and numbers and is exactly 8 chars long.
                /^[a-z0-9]{8}$/
                </pre>
                <a href="#toc">back to toc</a></br>
                <h2 id="coding">Coding</h2>
                <pre>
                https://www.onlinegdb.com/online_c_compiler
                </pre>
                
                <a href="#toc">back to toc</a></br>
                <h2>Improvements, Training Ideas and other things to cover</h2>
                <pre>
                o http://overthewire.org/wargames/
                o script the basics. 
                o use Strings to look for clues in files
                
                SSH public key authentication
                OpenSSH
                
                SAMBA server pipeline authenticated
                /var/lib/samba/pipeline
                
                What Hacking Looks Like : 
                https://www.youtube.com/watch?v=8osxqtNgESI&amp;feature=youtu.be&amp;utm_source=youtube&amp;utm_medium=video&amp;utm_content=full_webinar&amp;utm_campaign=what_hacking_looks_like_webinar
                
                </pre>
                <a href="#toc">back to toc</a></br>
            </div>
                
                    
        </body>
    </html>
