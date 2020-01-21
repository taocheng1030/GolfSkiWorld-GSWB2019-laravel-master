@if(count($model->bookings))
<table id="users" class="table table-hover table-striped">
    <thead>
    <tr>
        <td>Login</td>
        <td>Full name</td>
        <td>Email</td>
        <td>Phone</td>
    </tr>
    </thead>

    <tbody>
    @foreach ($model->bookings as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->profile->firstname }} {{ $user->profile->lastname }}</td>
            <td>{{ HTML::mailto($user->email) }}</td>
            <td>{{ $user->profile->phone }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
@else
<div>Not found</div>
@endif