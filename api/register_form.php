<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IEIA 2024 Interlinx Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
<div class="container mx-auto p-8">
    <h2 class="text-2xl font-bold text-center mb-8">IEIA 2024 Interlinx Registration</h2>
    <form action="submit_form.php" method="post" class="bg-white p-6 rounded-lg shadow-lg">
        <div class="mb-4">
            <label for="first_name" class="block text-gray-700">First Name:</label>
            <input type="text" id="first_name" name="first_name" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
        </div>
        <div class="mb-4">
            <label for="last_name" class="block text-gray-700">Last Name:</label>
            <input type="text" id="last_name" name="last_name" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
        </div>
        <div class="mb-4">
            <label for="designation" class="block text-gray-700">Designation:</label>
            <input type="text" id="designation" name="designation" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
        </div>
        <div class="mb-4">
            <label for="email" class="block text-gray-700">Email:</label>
            <input type="email" id="email" name="email" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
        </div>
        <div class="mb-4">
            <label for="country_code" class="block text-gray-700">Country Code:</label>
            <input type="text" id="country_code" name="country_code" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
        </div>
        <div class="mb-4">
            <label for="phone" class="block text-gray-700">Phone:</label>
            <input type="tel" id="phone" name="phone" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
        </div>
        <div class="mb-4">
            <label for="company" class="block text-gray-700">Company:</label>
            <input type="text" id="company" name="company" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
        </div>
        <div class="mb-4">
            <label for="country" class="block text-gray-700">Country:</label>
            <input type="text" id="country" name="country" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
        </div>
        <div class="mb-4">
            <label for="delegate_type" class="block text-gray-700">Delegate Type:</label>
            <input type="text" id="delegate_type" name="delegate_type" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
        </div>
        <div class="text-center">
            <input type="submit" value="Submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
        </div>
    </form>
</div>
</body>
</html>
