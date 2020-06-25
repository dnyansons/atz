			</div>
		</div>
	</div>
</div>
<script src="<?php echo base_url();?>assets/admin/bower_components/jquery/js/jquery.min.js"></script>
<script src="<?php echo base_url();?>assets/admin/bower_components/jquery-ui/js/jquery-ui.min.js"></script>
<script src="<?php echo base_url();?>assets/admin/bower_components/popper.js/js/popper.min.js"></script>
<script src="<?php echo base_url();?>assets/admin/bower_components/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo base_url();?>assets/admin/bower_components/jquery-slimscroll/js/jquery.slimscroll.js"></script>
<script src="<?php echo base_url();?>assets/admin/bower_components/modernizr/js/modernizr.js"></script>

<script type="text/javascript" type="text/javascript" src="<?php echo base_url(); ?>assets/admin/bower_components/chart.js/js/Chart.js"></script>

<script src="<?php echo base_url();?>assets/admin/bower_components/modernizr/js/css-scrollbars.js"></script>
<script src="<?php echo base_url();?>assets/admin/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>assets/admin/bower_components/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url();?>assets/admin/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url();?>assets/admin/bower_components/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo base_url();?>assets/admin/pages/jquery.filer/js/jquery.filer.min.js"></script>
<script src="<?php echo base_url();?>assets/admin/pages/filer/custom-filer.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/admin/pages/filer/jquery.fileuploads.init.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/admin/js/classie.js"></script>
<script src="<?php echo base_url();?>assets/admin/js/modalEffects.js"></script>
<script src="<?php echo base_url();?>assets/admin/pages/product-list/product-list.js"></script>
<script src="<?php echo base_url();?>assets/admin/bower_components/i18next/js/i18next.min.js"></script>
<script src="<?php echo base_url();?>assets/admin/bower_components/i18next-xhr-backend/js/i18nextXHRBackend.min.js"></script>
<script src="<?php echo base_url();?>assets/admin/bower_components/i18next-browser-languagedetector/js/i18nextBrowserLanguageDetector.min.js"></script>
<script src="<?php echo base_url();?>assets/admin/bower_components/jquery-i18next/js/jquery-i18next.min.js"></script>
<script src="<?php echo base_url();?>assets/admin/js/pcoded.min.js"></script>
<script src="<?php echo base_url();?>assets/admin/js/vartical-layout.min.js"></script>
<script src="<?php echo base_url();?>assets/admin/js/jquery.mCustomScrollbar.concat.min.js"></script>

<script src="<?php echo base_url();?>assets/admin/js/script.js"></script>
<script src="<?php echo base_url();?>assets/admin/js/ckeditor/ckeditor/ckeditor.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/tageditor/tageditor/js/jquery.amsify.suggestags.js"></script>


<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/pages/widget/amchart/amcharts.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/pages/widget/amchart/serial.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/pages/widget/amchart/light.js"></script>

<script src="<?php echo base_url(); ?>assets/admin/pages/advance-elements/moment-with-locales.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/bower_components/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/pages/advance-elements/bootstrap-datetimepicker.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/bower_components/bootstrap-daterangepicker/js/daterangepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/bower_components/datedropper/js/datedropper.min.js"></script>

<script src="<?php echo base_url(); ?>assets/admin/bower_components/modernizr/js/css-scrollbars.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/bower_components/stroll/js/stroll.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/pages/list-scroll/list-custom.js"></script>

<script src="<?php echo base_url(); ?>assets/admin/js/jquery.validate.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/custom_validations_seller.js"></script>


<script src="https://www.gstatic.com/firebasejs/6.0.2/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/6.0.2/firebase-messaging.js"></script>
<script>

  // Initialize Firebase 
  var config = {
    apiKey: "AIzaSyB2N3Z-muoFs_jjjUU--QGuq9eeE7JK5hE",
    authDomain: "atzcart-1555070479316.firebaseapp.com",
    databaseURL: "https://atzcart-1555070479316.firebaseio.com",
    projectId: "atzcart-1555070479316",
    storageBucket: "atzcart-1555070479316.appspot.com",
    messagingSenderId: "281653898466",
    appId: "1:281653898466:web:a496c0b63350caf3"
  };
  firebase.initializeApp(config);
  const messaging = firebase.messaging();
  messaging.usePublicVapidKey('BG76f74c1o6KUtLP-hAJdD-SRoF3mWvmMnK_lkGcG9ugUR25Nnv3Yr6Zt_8PMJyiKWm3-aQ2NtPPNPNqP3LAGyI');
  requestPermission();

  // [START refresh_token]
  // Callback fired if Instance ID token is updated.
  messaging.onTokenRefresh(function() {
    messaging.getToken().then(function(refreshedToken) {
      setTokenSentToServer(false);
      sendTokenToServer(refreshedToken);
      resetUI();
      // [END_EXCLUDE]
    }).catch(function(err) {
      //console.log('Unable to retrieve refreshed token ', err);
      showToken('Unable to retrieve refreshed token ', err);
    });
  });

  messaging.onMessage(function(payload) {
    //console.log('Message received. ', payload);
	notifyfirebase('click',payload);
  });


  function resetUI() {
    messaging.getToken().then(function(currentToken) {
      console.log(currentToken);
	  if (currentToken) {
        sendTokenToServer(currentToken);
      } else {
        setTokenSentToServer(false);
      }
    }).catch(function(err) {
      setTokenSentToServer(false);
    });
  }


  function showToken(currentToken) {
	//console.log(currentToken);
  }

  // Send the Instance ID token your application server, so that it can:
  // - send messages back to this app
  // - subscribe/unsubscribe the token from topics
  function sendTokenToServer(currentToken) {
    
    if (!isTokenSentToServer()) 
	{
      //console.log('Sending token to server...');
      
	  // TODO(developer): Send the current token to your server.
      setTokenSentToServer(true);
	  //console.log(currentToken);
	   $.ajax({
			url:"<?php echo base_url(); ?>seller/dashboard/updatetoken",
			type:"POST",
			data:{token:currentToken},
			success:function(data)
			{
				console.log('Token Updated Successfully');
			}
		});
    } 
	else 
	{
	   //console.log(currentToken);
	    $.ajax({
			url:"<?php echo base_url(); ?>seller/dashboard/updatetoken",
			type:"POST",
			data:{token:currentToken},
			success:function(data)
			{
                            console.log('Token Updated Successfully');
			}
		});
      //console.log('Token already sent to server so won\'t send it again ' + 'unless it changes');
    }

  }

  function isTokenSentToServer() {
    return window.localStorage.getItem('sentToServer') === '1';
  }

  function setTokenSentToServer(sent) {
    window.localStorage.setItem('sentToServer', sent ? '1' : '0');
  }

  function requestPermission() 
  {
	  //console.log('Notification permission Requesting.');
    messaging.requestPermission().then(function() {
      resetUI();
     //console.log('Notification permission granted.');
    }).catch(function(err) {
      //console.log('Unable to get permission to notify.', err);
    });
  }
  
	function notifyfirebase(event,payload) 
	{
		var received = JSON.stringify(payload, null, 2);
		var obj = JSON.parse(received);
		var title;
		var options;
		title = obj.data.title;
		options={
					body: obj.data.body + "-" + obj.data.tag,
					tag: 'preset',
                                        //sound : "default",
					icon: 'https://atzcart.com/firebaseicon.png'
				};
		Notification.requestPermission(function() 
		{
			var notification = new Notification(title, options);			
		}); 
		
	}
</script>
</body>
</html>