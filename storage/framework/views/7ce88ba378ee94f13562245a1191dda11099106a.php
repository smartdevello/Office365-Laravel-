<?php echo $__env->make("header", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-6">
			<div class="card">
				<div class="card-header">Pending Notifications</div>
				<div class="card-body">
				<?php $__currentLoopData = $AllNotification; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ALN): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<a href="<?php echo e($ALN->notification_link); ?>" target="_blank" onClick="ReadNoti(<?php echo e($ALN->notification_id); ?>)"><div class="alert alert-danger"><?php echo e($ALN->notification_text); ?></div></a>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</div>
			</div>
		</div>
	</div>
</div>
</body>

<script src="https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.23.0/firebase-messaging.js"></script>


<script>

const applicationServerPublicKey = 'BPNfXSsONLRk6JOMQyacaHIyHUeveMRlHb-QNKDQOiupFLpg8N1YG4XRpRTUus5Jgj8ELUVfAUR8UiPpZWGBvMQ';
const applicationServerKey = "AAAA7dL2HG0:APA91bHlIwzEdSZQAJfWKSFSRqtTB7eBEbVAPC7vgzXwSGBxcA3jX8FoVYusM5OSIfhluY5eA_qcJlQD5PC8Hqz_EyHVwOfVRA2DUxksGT3ENwWd0yOO5s8VygJWXy02BToVTG_vacgH";
let isSubscribed = false;
let swRegistration = null;

	
var firebaseConfig = {
    apiKey: "AIzaSyB8HaCwa_lK4FXkLmkxJyd3UFOY9qaDCSY",
    authDomain: "cornerstone-411a2.firebaseapp.com",
    databaseURL: "https://cornerstone-411a2.firebaseio.com",
    projectId: "cornerstone-411a2",
    storageBucket: "cornerstone-411a2.appspot.com",
    messagingSenderId: "1021446593645",
    appId: "1:1021446593645:web:cbcea34861afd168cf7364"
  };

	firebase.initializeApp(firebaseConfig);

const messaging = firebase.messaging();
messaging.usePublicVapidKey(applicationServerPublicKey);


messaging.getToken().then((currentToken) => {
  if (currentToken) {
	  console.log(currentToken);
    sendTokenToServer(currentToken);
  } else {
    console.log('No Instance ID token available. Request permission to generate one.');
  }
}).catch((err) => {
  console.log('An error occurred while retrieving token. ', err);
  console.log('Error retrieving Instance ID token. ', err);
});

messaging.onMessage((payload) => {
  console.log('Message received. ', payload);
});
	
function sendTokenToServer(token){
	$.ajax({
		url: '<?php echo e(URL("SaveFCM")); ?>',
		type: 'post',
		data: {Code: token},
		cache: false,
		success: function (data) {
		}
	});
}

function ReadNoti(id){
	$.ajax({
		url: '<?php echo e(URL("ReadNoti")); ?>?id='+id,
		type: 'get',
		cache: false,
		success: function (data) {
			window.location.reload()
		}
	});
}

</script>
</html>
<?php /**PATH /var/www/vhosts/cornerstoneremovals.co.uk/dev6.cornerstoneremovals.co.uk/resources/views/dashboard.blade.php ENDPATH**/ ?>