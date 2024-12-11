<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Loader with Progress Bar</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      overflow: hidden; /* Prevent scrolling while the loader is active */
    }

    #loader {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: #fcfdff;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      z-index: 1000;
    }

    #progress-bar-container {
      width: 20%;
      height: 10px;
      background: #eeeeee;
      border-radius: 5px;
      overflow: hidden;
      position: relative;
    }

    #progress-bar {
      width: 0%;
      height: 100%;
      background: #379df0;
      border-radius: 5px;
      transition: width 0.1s linear;
    }

    #content {
      display: none;
    }
  </style>
</head>
<body>
  <div id="loader">
    <img src="favicon.ico" alt="" style="width: 4%;">
    <p style="padding:10px;font-size:2rem;font-weight:300;color:#006ee4;"> </p>
    <div id="progress-bar-container">
        <div id="progress-bar"></div>
    </div>
  </div>
  <div id="content">
    <!-- Your main content goes here -->
    <h1>Welcome to the Website!</h1>
    <p>This is the main content that appears after the loader.</p>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const loader = document.getElementById("loader");
      const content = document.getElementById("content");
      const progressBar = document.getElementById("progress-bar");

      let progress = 0;
      const interval = setInterval(() => {
        progress += 1; // Increment progress by 5% every 100ms
        progressBar.style.width = progress + "%";

        if (progress >= 100) {
          clearInterval(interval); // Stop progress when it reaches 100%
          loader.style.display = "none";
          content.style.display = "block";
          document.body.style.overflow = "auto"; // Allow scrolling after loader disappears
        }
      }, 25); // Update every 50ms
    });
  </script>
</body>
</html>
