<form action="{{ route('mobile_api::uploadContent') }}" method="post" accept-charset="utf-8" enctype="multipart/form-data">
    <input type="hidden" name="key" value="wzsm9XrRWq3caJoQMSHSrvAllfQ7lzao4R97LWP6lIq2912tjHili3MLPHpZ">
    <input type="hidden" name="user_id" value="1902">
    <input type="hidden" name="original_filename" value="jasdfhsfslfsd.mp4">
    <input type="hidden" name="country_code" value="IL">
    <input type="hidden" name="latitude" value="12.342424">
    <input type="hidden" name="longitude" value="3.3424234">
    <input type="hidden" name="date" value="2016-10-03">
    <input type="hidden" name="time" value="05:04:30">
    <input type="hidden" name="type" value="video">

    <input type="file" name="video" value="" placeholder="">
    <button type="submit">Upload</button>
</form>