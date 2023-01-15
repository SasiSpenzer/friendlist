
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Friends List') }}
        </h2>
    </x-slot>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="input-group mb-3">
                        <input type="email" name="inviteEmail" id="inviteEmail"  class="form-control" placeholder="Friend's Email" aria-label="Friend's Email" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-success" id="inviteFriends" type="button">Invite Friends </button>

                        </div>

                    </div>
                    <div id="showEmailErrors" style="display: none;" class="alert alert-danger" role="alert">
                        Please enter Valid Email
                    </div>
                    <div style="display: none" id="loaderT" class="loader"></div>

                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    <table id="friendstable" class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Friends Email</th>
                            <th scope="col">Actions</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($friends as $key=>$each_friend)
                        <tr id="{{$each_friend['id']}}">
                            <th scope="row">{{$key+1}}</th>
                            <td>{{$each_friend['friend_email']}}</td>
                            <td><button onclick="makeDelete({{$each_friend['id']}});" type="button" class="btn btn-danger">Delete</button></td>
                        </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script
        src="https://code.jquery.com/jquery-3.6.3.min.js"
        integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU="
        crossorigin="anonymous"></script>
    <script type="text/javascript" src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('js/friends.js') }}" defer></script>
    <link href="{{ asset('css/list.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
</x-app-layout>
