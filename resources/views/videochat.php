<html itemscope itemtype="http://schema.org/Product" prefix="og: http://ogp.me/ns#" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
    <title>TSM Meetings</title>
    <style type="text/css">
        body{
            background: #474747;
            color: #fefefe;
        }
    </style>
</head>
<body>
    <div id="meet">Loading...</div>

    <script src="https://meet.jit.si/external_api.js"></script>
    <script type="text/javascript">  
        var url = window.location.pathname,
            roomid = url.substring(url.lastIndexOf('/') + 1);
            roomid += '-'+ Date.now(),
            meet =  document.querySelector('#meet'); 

        meet.innerHTML = '';
        
        var domain = "meet.jit.si";
        var options = {
            roomName: roomid,            
            parentNode: meet,
            configOverwrite: {
                disableDeepLinking: true,
                
            },
            interfaceConfigOverwrite: {
             //   filmStripOnly: true,
              SHOW_JITSI_WATERMARK: false,
              DISABLE_JOIN_LEAVE_NOTIFICATIONS: true,
              DEFAULT_REMOTE_DISPLAY_NAME: 'You',
              DEFAULT_LOCAL_DISPLAY_NAME: 'me',
            }
        }
        var api = new JitsiMeetExternalAPI(domain, options);  
    </script>
</body>
</html>    

