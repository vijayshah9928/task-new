<table class="table">
    <thead class="thead-dark">
        <tr>
        <th scope="col">#</th>
        <th scope="col">Profile</th>
        <th scope="col">Name</th>
        <th scope="col">Email</th>
        <th scope="col">Phone</th>
        <th scope="col">Role</th>
        </tr>
    </thead>
    <tbody >
        @if(!$users->isEmpty())
            @foreach ($users as $user)
                <tr>
                    <th scope="row">{{ $user->id }}</th>
                    <td><img src="{{ asset('storage/profile_image/'.$user->profile_image) }}" width="50px"></td>
                    <td>{{  $user->name }}</td>
                    <td>{{  $user->email }}</td>
                    <td>{{  $user->phone }}</td>
                    <td>{{  $user->role->name }}</td>
                </tr>
            @endforeach
            @else
            <tr>
                <td colspan="6">No Data Found</td>
            </tr>
        @endif
    </tbody>
</table>
{!! $users->render() !!}