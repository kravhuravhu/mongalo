@props(['size' => 'lg'])
<div {{ $attributes->class(['in__monogram', 'in__monogram--' . $size]) }} aria-hidden="true">
    <span class="in__monogram-i">i</span><span class="in__monogram-n">N</span>
</div>