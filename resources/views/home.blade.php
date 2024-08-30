<div>
    <h2>Comments Homepage</h2> 
    <b>Semantic Search</b>
    <form action="search" method="get">
        <input type="text" placeholder="Search Comments", name="searchComments", value="{{@$searchInfo}}">
        <button>Search</button>
    </form>
    <b>Semantic Filter</b>
    <form action="filter" method="get">
        <input type="radio", name="filter", id="rad1", value="positive", onclick="toggleRadio(this)", {{ @$isSelect == 1 ? 'checked' : '' }}>
        <label for="rad1">Positive</label>
        <input type="radio", name="filter", id="rad2", value="negative", onclick="toggleRadio(this)", {{ @$isSelect == 2 ? 'checked' : '' }}>
        <label for="rad2">Negative</label>
        <input type="radio", name="filter", id="rad3", value="neutral", onclick="toggleRadio(this)", {{ @$isSelect == 3 ? 'checked' : '' }}>
        <label for="rad3">Neutral</label>
        <input type="submit" value="Submit">
    </form>
    <table border="1">
        <tr>
            <td align = "center">User id</td>
            <td align = "center">Username</td>
            <td align = "center">Comment</td>
            <td colspan="2", align = "center">Operation</td>
        </tr>
        @foreach($usersInfo as $userInfo)
        <tr>
            <td align = "center">{{$userInfo->ID}}</td>
            <td align = "center">{{$userInfo->Name}}</td>
            <td>{{$userInfo->Comment}}</td>
            <td><a href="{{'delete/'.$userInfo->ID}}">delete</a></td>
            <td><a href="{{'update/'.$userInfo->ID}}">update</a></td>
        </tr>
        @endforeach
    </table>
    <br>
    <a href="{{'add'}}">Add Comment</a>
</div>

<script>
//Javascript
function toggleRadio(radio) {
    if (radio.wasChecked) {
        radio.checked = false;
    }
    radio.wasChecked = radio.checked;
}

// Set wasChecked for the radio buttons when the page loads
window.onload = function() {
    document.querySelectorAll('input[type=radio]').forEach(radio => radio.wasChecked = radio.checked);
};
</script>