$(document).ready(function () {
    $('#friendstable').DataTable();


    $("#inviteFriends").click(function (){

        var inviteEmail = $("#inviteEmail").val();
        var results = isEmail(inviteEmail);
        $("#loaderT").show();
        if(results){
            $.ajax({
                url: '/invite-friends',
                type: 'POST',
                data: {
                    "email": inviteEmail,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }).done(function (e) {

                if(e.status == false){
                    $("#loaderT").hide();
                    $("#showEmailErrors").show();
                    $("#showEmailErrors").html(e.msg);
                    setTimeout(function(){

                        $("#showEmailErrors").hide('slow');

                    }, 2000);

                } else {
                    $("#loaderT").hide();
                    Swal.fire(
                        'Success',
                        'Your Invitation Sent Successfully ! Once your Friend Confirms your Requested He/She will be added to your list.',
                        'success'
                    )
                }


            });
        } else {
            $("#showEmailErrors").show();
            setTimeout(function(){
                $("#loaderT").hide();
                $("#showEmailErrors").hide('slow');
            }, 2000);
        }

    });

});
function isEmail(email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
}
function makeDelete(id) {

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/friend_list',
                    type: 'POST',
                    data: {
                        "id": id,
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                }).done(function (e) {;
                    Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                    $("#"+id+"").hide('slow');
                });

            }
        })

}

