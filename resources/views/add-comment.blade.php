<div>
    <h2>Add New Comments</h2>
    <form action="" method="post">
        @csrf
        <div class="input-wrapper">
            <input type="text", placeholder="Enter Your ID", name="userID" value="{{old('userID')}}">
            <span style="color:red">@error('userID'){{$message}}@enderror</span>
        </div>
        <div class="input-wrapper">
            <input type="text", placeholder="Enter Your Name", name="userName" value="{{old('userName')}}">
            <span style="color:red">@error('userName'){{$message}}@enderror</span>
        </div>
        <div class="input-wrapper">
            <input type="text", placeholder="Enter Your Comment", name="userComment" value="{{old('userComment')}}">
            <span style="color:red">@error('userComment'){{$message}}@enderror</span>
        </div>
        <div class="input-wrapper">
            <button>Add New Comment</button>
        </div>
    </form>
    <a href="{{'home'}}">Go to Home</a>
    <!-- The only way to do great work is to love what you do. - Steve Jobs -->
</div>
