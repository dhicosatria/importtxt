<html>
    <body>
        <form action="{{ url('processRegister') }}" method="post">
        @csrf
        <input type="text" name="username" placeholder="username"><br/>
        <input type="text" name="password" placeholder="password"><br/>
        <input type="submit">
        </form>
    </body>
</html>