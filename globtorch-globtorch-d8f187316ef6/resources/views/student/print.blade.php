<html>
    <head>
        <title>All Students</title>
        <style>
            table {
              font-family: arial, sans-serif;
              border-collapse: collapse;
              width: 100%;
            }
            
            td, th {
              border: 1px solid #dddddd;
              text-align: left;
              padding: 8px;
            }
            
            tr:nth-child(even) {
              background-color: #dddddd;
            }
        </style>
    </head>
    <body>
        <h1>Globtorch Study Platform - All students</h1>
        <div>
            <table>
                <tr>
                    <th></th>
                    <th>Surname</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                </tr>
                @foreach ($students as $key => $student)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$student->surname}}</td>
                    <td>{{$student->name}}</td>
                    <td>{{$student->email}}</td>
                    <td>{{$student->phone}}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </body>
</html>