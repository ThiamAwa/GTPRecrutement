<!DOCTYPE html>
<html>
<head>
    <title>New Mission Added</title>
</head>
<body>
<h1>New Mission Added</h1>
<p>A new mission has been added with the following details:</p>

<ul>
    <li><strong>Title:</strong> {{ $mission->title }}</li>
    <li><strong>Description:</strong> {{ $mission->description }}</li>
    <li><strong>Start Date:</strong> {{ $mission->start_date }}</li>
    <li><strong>End Date:</strong> {{ $mission->end_date }}</li>
</ul>

<p>Attached is the detailed mission information in PDF format.</p>
</body>
</html>
