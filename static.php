<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <p>This is a Static Page</p>
    <h1>This will have a input form</h1>

    <form action="dynamic.php" method="get">
        <label>Name: </label>
        <input type="text" name="name" placeholder="Enter your name..." required>
        <br>
        <label>Email: </label>
        <input type="email" name="email" placeholder="Enter your email..." required>
        <br>
        <label>Password: </label>
        <input type="password" name="password" placeholder="Enter your password..." required>
        <br>
        <label>Gender: </label>
        <input type="radio" name="gender" value="female" required> Female
        <input type="radio" name="gender" value="male" required> Male
        <br>
        <label>Hobbies: </label>
        <input type="checkbox" name="hobbies[]" value="reading"> Reading
        <input type="checkbox" name="hobbies[]" value="traveling"> Traveling
        <input type="checkbox" name="hobbies[]" value="gaming"> Gaming
        <br>
        <label>Description: </label>
        <textarea name="description" placeholder="Enter a brief description..."></textarea>
        <br>
        <label>Country: </label>
        <select name="country" required>
            <option value="">Select a country...</option>
            <option value="usa">United States</option>
            <option value="canada">Canada</option>
            <option value="uk">United Kingdom</option>
        </select>
        <br>
        <button type="submit">Submit</button>
    </form>

</body>
</html>
