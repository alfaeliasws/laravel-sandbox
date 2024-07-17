<html>
  <head>
    <title>Say Hi</title>
    <body>
      <form action="/form" method="post">
        <label for="name">
          <input type="text" name="name">
        </label>
        <input type="submit" value="Say Hello">
        <input type="hidden" value="_token" value={{csrf_token()}}>
      </form>
    </body>
  </head>
</html>