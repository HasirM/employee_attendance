
<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
  </div>

  <!-- Content Row -->
  <div class="row">

    <div class="col">
      <div class="row">

        <!-- Area Chart -->
        <div class="col-xl-12 col-lg-7">
          <div class="card shadow mb-4" style="min-height: 543px">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-dark">Stamp your Attendance!</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
              <?php if ($weekends == true) : ?>
                <h1 class="text-center my-3">THANK YOU FOR THIS WEEK!</h1>
                <h5 class="card-title text-center mb-4 px-4">Have a Good Rest this <b>WEEKEND</b></h5>
                <b>
                  <p class="text-center text-dark pt-3">See You on Monday!</p>
                </b>
                <div class="row">
                  <button disabled class="btn btn-danger btn-sm text-xs mx-auto" style="font-size: 35px; width: 200px; height: 200px">
                    <i class="fas fa-fw fa-sign-out-alt fa-2x"></i>
                  </button>
                </div>
              <?php else : ?>
                <?php if ($in == false) : ?>
                  <?= form_open('attendance', 'id="attendanceForm"'); ?>
                  <div class="row mb-3">
                    <div class="col-lg-5">
                      <input type="hidden" name="work_shift" value="<?= $account['shift']; ?>">
                      <label for="work_shift" class="col-form-label">Work Shift</label>
                      <input class="form-control" type="text" placeholder="<?= date("h:i A", strtotime('2022-06-23 ' . $startTime)); ?> - <?= date("h:i A", strtotime('2022-06-23 ' . $endTime)); ?>" value="<?= date("h:i A", strtotime('2022-06-23 ' . $startTime)); ?> - <?= date("h:i A", strtotime('2022-06-23 ' . $endTime)); ?>" readonly>
                    </div>
                    <div class="col-lg-5 offset-lg-1">
                      <label for="location" class="col-form-label">Time In Location</label>
                      <select class="form-control" name="location" id="location">
                        <?php foreach ($location as $lct) : ?>
                          <option value="<?= $lct['id'] ?>"><?= $lct['id']; ?> = <?= $lct['name'] ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-lg-5 text-center">
                      <div class="row col">
                        <label for="image" class="col-form-label float-left">Capture Image</label>
                        <button type="button" class="btn btn-primary ml-2" id="openCameraButton">Open Camera</button>
                      </div>
                      <video id="video" class="img-thumbnail rounded mb-2" style="max-height: 252px; display: none;"></video>
                      <canvas id="canvas" style="display: none;"></canvas>
                      <img id="output" class="img-thumbnail rounded mb-2" style="max-height: 252px; display: none;">
                      <button type="button" class="btn btn-primary" id="takePictureButton" style="display: none;">Take Picture</button>
                      <button type="button" class="btn btn-danger" id="retakeButton" style="display: none;">Retake</button>
                    </div>
                    <div class="col-lg-5 offset-lg-1 text-center">
                      <label for="notes" class="float-left">Live Location</label>
                      <textarea id="live_location" maxlength="120" class="form-control mb-4" name="notes" id="notes" rows="3" style="resize: none;" readonly>live location here</textarea>
                      <textarea id="base64_image" maxlength="120" class="form-control mb-4" name="base64_image" id="base64_image" rows="3" style="resize: none; display:none;" readonly>Sample notes</textarea>
                      <hr>
                      <button type="submit" id="uploadButton" class="btn btn-primary bg-gradient-primary px-5 btn-lg rounded-pill">
                        <i class="fas fa-fw fa-sign-in-alt"></i> Time In
                      </button>
                      <hr>
                    </div>
                  </div>
                  <?= form_close(); ?>
                <?php else : ?>
                  <h3 class="text-center my-3">THANK YOU FOR TODAY</h3>
                  <h6 class="card-title text-center mb-4 px-4">The world of business survives less on leadership skills and more on the commitment and dedication of passionate employees like you.<br>Thank you for your hard work.</h6>
                  <?php if ($disable == false) : ?>
                    <div class="row">
                      <a href="<?= base_url('attendance/checkout') ?>" onclick="return confirm('Time Out now? Make sure you are done with you work!')" class="btn btn-danger bg-gradient-danger rounded-pill px-5 btn-lg mx-auto">
                        <i class="fas fa-fw fa-sign-out-alt"></i> <b>Time Out</b>
                      </a>
                    <?php else : ?>
                      <b>
                        <p class="text-center text-dark pt-3">See You Tomorrow!</p>
                    </div>
                  <?php endif; ?>
                <?php endif; ?>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End  -->
  </div>
  <!-- /.container-fluid -->

</div>

<script>
  var video;
  var canvas;
  var context;
  var stream;

  function startCamera() {
    navigator.mediaDevices.getUserMedia({
        video: true
      })
      .then(function(mediaStream) {
        stream = mediaStream;
        video = document.getElementById('video');
        canvas = document.getElementById('canvas');
        context = canvas.getContext('2d');

        video.srcObject = mediaStream;
        video.play();

        video.style.display = 'block';
        document.getElementById('takePictureButton').style.display = 'inline-block';
        document.getElementById('openCameraButton').style.display = 'none';

        document.getElementById('takePictureButton').addEventListener('click', takePicture);
      })
      .catch(function(err) {
        console.error('Error accessing camera: ', err);
      });
  }

  function takePicture() {
    var videoWidth = video.videoWidth;
    var videoHeight = video.videoHeight;

    // Set canvas dimensions to match video dimensions
    canvas.width = videoWidth;
    canvas.height = videoHeight;

    // Draw video frame onto canvas
    context.drawImage(video, 0, 0, videoWidth, videoHeight);

    // Convert canvas to image data URL
    var imageDataURL = canvas.toDataURL('image/jpeg');

    // Display captured image
    var output = document.getElementById('output');
    output.src = imageDataURL;
    output.style.display = 'block';
    
    document.getElementById("base64_image").innerHTML = imageDataURL;


    // Hide video
    video.style.display = 'none';

    // Stop the camera stream
    stopCamera();

    // Hide take picture button and show retake button
    document.getElementById('takePictureButton').style.display = 'none';
    document.getElementById('retakeButton').style.display = 'inline-block';
  }

  function retakePicture() {
    // Show video and canvas
    video.style.display = 'block';
    canvas.style.display = 'none';
    output.style.display = 'none';

    // Start the camera stream again
    startCamera();

    // Show take picture button and hide retake button
    document.getElementById('takePictureButton').style.display = 'inline-block';
    document.getElementById('retakeButton').style.display = 'none';
  }

  function stopCamera() {
    if (stream) {
      const tracks = stream.getTracks();
      tracks.forEach(track => {
        track.stop();
      });
    }
  }

  document.getElementById('openCameraButton').addEventListener('click', startCamera);
  document.getElementById('retakeButton').addEventListener('click', retakePicture);

  window.onload = function() {
    getLocation();
  };

  function getLocation() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(showPosition);
    } else {
      document.getElementById("live_location").innerHTML = "Geolocation is not supported by this browser.";
    }
  }

  function showPosition(position) {
    var latitude = position.coords.latitude;
    var longitude = position.coords.longitude;

    // Reverse Geocoding
    var apiEndpoint = "https://nominatim.openstreetmap.org/reverse?";
    var apiKey = ""; // Optional: If you have an API key for Nominatim, you can add it here
    var format = "json";
    var url = `${apiEndpoint}format=${format}&lat=${latitude}&lon=${longitude}&${apiKey}`;

    fetch(url)
      .then(response => response.json())
      .then(data => {
        var address = data.display_name;
        document.getElementById("live_location").innerHTML = address;
      })
      .catch(error => {
        console.error('Error:', error);
      });
  }
</script>
