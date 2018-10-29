<?php $images = $content->images; ?>
<div id="photos-carousel" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner" role="listbox">
        @foreach ($images as $key => $image)
            <div class="item {{ $key == 0 ? 'active' : null }}">
                <table width="100%" height="500">
                    <tr>
                        <td>
                            <img src="{{ $image->url($content->original_filename, 500) }}" alt="{{ $content->title }}" class="img-responsive">
                        </td>
                    </tr>
                </table>
            </div>
        @endforeach
    </div>
    
    @if (count($images) > 1)
        <a class="left carousel-control" href="#photos-carousel" role="button" data-slide="prev" style="display:none;">
            <span class="fa fa-chevron-circle-left fa-2x" aria-hidden="true"></span>
        </a>
        <a class="right carousel-control" href="#photos-carousel" role="button" data-slide="next" style="display:none;">
            <span class="fa fa-chevron-circle-right fa-2x" aria-hidden="true"></span>
        </a>
    @endif
</div>