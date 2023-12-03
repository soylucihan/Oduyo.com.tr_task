<!DOCTYPE html>
<html>
<head>
  <title>Queue Management</title>
</head>
<style>
    table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
    }
    th, td {
        padding: 5px;
        text-align: left;
    }
    th{background-color:#4CAF50;}
    tr:hover {background-color:#f5f5f5;}
    button{
        padding: 5px;
        margin: 5px;
    }
    .action{
        display: flex;
        flex-wrap: wrap;
    }

</style>
<body>
  <h1>Queue Management</h1>
  <table border="1">
  <tr>
          <th>Queue Id</th>
          <th>Queue</th>
          <th>Created</th>
          <th>Action</th>
      </tr>
  @foreach ($jobs as $job)
<tr>
   <td>{{ $job->id }}</td>
   <td>{{ $job->queue }}</td>
   <td>{{ $job->created_at }}</td>
   <td class="action">
       <form method="POST" action="/queue-management/cancel/{{ $job->id }}">
           @csrf
           <button type="submit">Cancel</button>
       </form>
       <form method="POST" action="/queue-management/re-execute/{{ $job->id }}">
           @csrf
           <button type="submit">Re-execute</button>
       </form>
   </td>
</tr>
@endforeach
  </table>
  <h1>Queue List</h1>
  <table border="1">
      <tr>
          <th>Queue Id</th>
          <th>Queue</th>
          <th>Created</th>
      </tr>
      @foreach ($jobs as $job)
      <tr>
          <td>{{ $job->id }}</td>
          <td>{{ $job->queue }}</td>
          <td>{{ $job->created_at }}</td>
      </tr>
      @endforeach
  </table>
</body>
</html>
