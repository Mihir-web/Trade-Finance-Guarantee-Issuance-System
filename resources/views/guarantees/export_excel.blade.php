<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Bills Report</title>
    </head>
    <body>
        <table>
            <thead>
                <tr>
                    <th><b>No</b></th>
                    <th><b>Title</b></th>
                    <th><b>Description</b></th>
                    <th><b>status</b></th>
                    <th><b>Author</b></th>             
                    <th><b>Date/Time</b></th>                   
                </tr>
            </thead>
            <tbody>
                @php $i = 1;

                @endphp



                @foreach($bills as $value)
                @php
                $status = '';
                if($value->status == 1)
                {
                    $status = "Initial Draft";
                }elseif($value->status == 2){
                    $status = "Under review";
                }elseif($value->status == 3){
                    $status = "Approved";
                }elseif($value->status == 4){
                    $status = "Rejected";
                }elseif($value->status == 5){
                    $status = "Voting Ongoing";
                }else{
                    $status = "Passed";
                }

                 if($value->description != ''){
                $description = $value->description;
                }else
                {
                $description = 'N/A'; 
                }

               

                @endphp
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $value->title }}</td>
                    
                  
                    <td>{{$description}}</td>
                    <td>{{ $status }}</td>
                    <td>{{$value->user->name}}</td>
                    <td>{{ $value->created_at }}</td>
                </tr>
                @php $i++; @endphp
                @endforeach
            </tbody>
        </table>
    </body>
</html>