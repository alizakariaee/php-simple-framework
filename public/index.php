<html>
    <head>
        <title>App</title>
    </head>
    <body>
        <h1>Home Page</h1>
        <script>
            fetch('http://localhost/app/api/updateUser?id=123', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json',
  },
  body: JSON.stringify({ fname: 'Ali', lname: 'Ramezani' }),
})
  /* .then((response) => response.json()) */
  .then((response) => response.text())
  .then((data) => console.log(data))
  .catch((error) => console.error('Error:', error));

        </script>
    </body>
</html>