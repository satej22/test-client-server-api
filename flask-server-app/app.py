from flask import Flask, json, request

app = Flask(__name__)



@app.route("/")
def login():
    return """
       <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login and Display API Result</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    table { border-collapse: collapse; width: 100%; margin-top: 20px; }
    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
    th { background-color: #f2f2f2; }
  </style>
</head>
<body>
  <h1>Login</h1>
  <form id="loginForm">
    <label for="userId">User ID:</label><br>
    <input type="text" id="userId" name="id" required><br><br>
    <label for="userPass">Password:</label><br>
    <input type="password" id="userPass" name="pass" required><br><br>
    <input type="submit" value="Login">
  </form>
  
  <!-- Container for displaying the API response -->
  <div id="output"></div>
  
  <script>
    document.getElementById("loginForm").addEventListener("submit", function(event) {
      event.preventDefault(); // Prevent default form submission
      
      // Get the user input values.
      const userId = document.getElementById("userId").value;
      const userPass = document.getElementById("userPass").value;
      
      // Build the API URL with query parameters.
      // Adjust the URL to match your deployed server endpoint.
      const apiUrl = "https://flask-database-mahv5jnbz-satejbhaves-projects.vercel.app/";
      const queryString = "?id=" + encodeURIComponent(userId) + "&pass=" + encodeURIComponent(userPass);
      const url = apiUrl + queryString;
      
      // Call the API endpoint.
      fetch(url)
        .then(response => {
          if (!response.ok) {
            throw new Error("Network response was not ok");
          }
          return response.json();
        })
        .then(data => {
          let html = "<h2>API Response</h2>";
          if (data.length === 0) {
            html += "<p>No user data found.</p>";
          } else {
            html += "<table>";
            html += "<thead><tr><th>User ID</th><th>Password Hash</th><th>Role</th></tr></thead><tbody>";
            data.forEach(user => {
              html += "<tr>";
              html += "<td>" + user.userid + "</td>";
              html += "<td>" + user.password_hash + "</td>";
              html += "<td>" + user.role + "</td>";
              html += "</tr>";
            });
            html += "</tbody></table>";
          }
          document.getElementById("output").innerHTML = html;
        })
        .catch(error => {
          console.error("Error fetching data:", error);
          document.getElementById("output").innerHTML = "<p style='color:red;'>Error fetching data.</p>";
        });
    });
  </script>
</body>
</html>

        """



