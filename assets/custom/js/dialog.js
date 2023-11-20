$('#addFriend').click(function(){
    $('#addfriendDialog').modal('toggle')
})

$('#blockadeFriend').click(function(){
    $('#blockadeFriendDialog').modal('toggle')
})

$('#delFriend').click(function(){
    $('#delFriendDialog').modal('toggle')
})
$('.operating').on('click',function(e) {
    console.log(e);
    $('#deleteItinerary').modal('toggle')
})
$('.operating2').on('click',function(e) {
    console.log(e);
    $('#Dialogreset').modal('toggle')
})