<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0; /* Remove default body margin */
            padding: 0; /* Remove default body padding */
            display: flex; /* Use flexbox to center content vertically and horizontally */
            justify-content: center; /* Center content horizontally */
            align-items: center; /* Center content vertically */
            height: 100vh; /* Set body height to viewport height */
        }

        .container {
            width: 30%; /* Set width to auto to adjust dynamically based on content */
            height: 30%;
            
            padding: 30px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        p {
            text-align: center;
            margin-bottom: 20px;
            color: #666;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        input[type="text"] {
            width: 95%;
            padding: 8px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button[type="submit"] {
            width: 100%;
            padding: 10px;
            font-size: 18px;
            background-color: #922B21;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #800000;
        }

</style>
<body>
<div class="container">
    <h2>Forgot Password?</h2>
    
    <form>
      <div class="form-group">
        <label for="email">Email address:</label>
        <input type="text" id="email" name="email" required>
      </div>
      <button type="submit">Send MSessage</button>
    </form>
  </div>
</body>
</html>