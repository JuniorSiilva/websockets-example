@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        <div class="alert alert-info notify-new-users" style="display: none !important;">
                            Sua lista possui novos registros.
                        </div>

                        <table class="table table-bordered users">
                            <thead>
                                <th class="text-center">#</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">Email</th>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr>
                                        <td class="text-center">{{ $user->id }}</td>
                                        <td class="text-center">{{ $user->name }}</td>
                                        <td class="text-center">{{ $user->email }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">No data available.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script src="{{asset('https://js.pusher.com/4.1/pusher.min.js')}}"></script>
<script>
    // Enable pusher logging - don't include this in production
    // Pusher.logToConsole = true;

    const pusher = new Pusher("{{ env('PUSHER_APP_KEY') }}", {
        cluster: "{{env('PUSHER_APP_CLUSTER')}}",
        encrypted: true
    });

    let channel = pusher.subscribe('admin');
    
    channel.bind('user.registered', function(data) {        
        updateTable(data.user);
    });

    function updateTable(user){
        $('table > tbody > tr:first').before(
            `<tr> 
                <td class="text-center"> ${user.id} </td> 
                <td class="text-center"> ${user.name} </td> 
                <td class="text-center"> ${user.email} </td> 
            </tr>`
        );

        $('div.notify-new-users').show('slow');

        setTimeout(function(){
            $('div.notify-new-users').hide(1000);
        }, 3000)
    }
  </script>
@endsection
