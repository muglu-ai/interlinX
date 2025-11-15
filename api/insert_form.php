<!DOCTYPE html>
<html>
<head>
    <title>Registration Form</title>
</head>
<body>
    <form id="registrationForm">
        <label for="title">Title:</label><br>
        <input type="text" id="title" name="title"><br>
        <label for="fname">First Name:</label><br>
        <input type="text" id="fname" name="fname"><br>
        <label for="lname">Last Name:</label><br>
        <input type="text" id="lname" name="lname"><br>
        <label for="designation">Designation:</label><br>
        <input type="text" id="designation" name="designation"><br>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email"><br>
        <label for="country_code">Country Code:</label><br>
        <input type="text" id="country_code" name="country_code"><br>
        <label for="mobile">Mobile:</label><br>
        <input type="text" id="mobile" name="mobile"><br>
        <label for="organisation">Organisation:</label><br>
        <input type="text" id="organisation" name="organisation"><br>
        <label for="country">Country:</label><br>
        <input type="text" id="country" name="country"><br>
        <input type="submit" value="Submit">
    </form>

    <script>
        document.getElementById('registrationForm').addEventListener('submit', function(event) {
            event.preventDefault();

            var data = {
                title: document.getElementById('title').value,
                fname: document.getElementById('fname').value,
                lname: document.getElementById('lname').value,
                designation: document.getElementById('designation').value,
                email: document.getElementById('email').value,
                country_code: document.getElementById('country_code').value,
                mobile: document.getElementById('mobile').value,
                organisation: document.getElementById('organisation').value,
                country: document.getElementById('country').value
            };

            fetch('https://interlinxpartnering.com/interlinx-2024/api/register.php', {
                method: 'POST',
                headers: {
                    'Access-Control-Allow-Origin': '*',
                    'Access-Control-Allow-Headers': 'access',
                    'Access-Control-Allow-Methods': 'POST',
                    'Content-Type': 'application/json',
                    'x-api-key' : 'AIzaSDyD51Q_7VGymsxVBgD3Py4_8ibV3SO0',
                    'Authorization' : 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VybmFtZSI6IldrQ29DUGVydGc4NTIxQUdERyIsImV4cCI6MTY5MjcyNTE3OX0.vnHj8kkQCqlTRMeN4YsufEiLddKl11Q7j0qQcBCsASY'
                },
                 body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => console.log(data))
            .catch((error) => {
              console.error('Error:', error);
            });
        });
    </script>
</body>
</html>