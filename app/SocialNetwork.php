<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int            $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property mixed          type
 * @property mixed          tooltip
 * @property mixed          link
 */
class SocialNetwork extends Model
{
    const TYPE_FACEBOOK = 'FACEBOOK';
    const TYPE_GOOGLE_PLUS = 'GOOGLE_PLUS';
    const TYPE_LINKEDIN = 'LINKEDIN';
    const TYPE_TWITTER = 'TWITTER';
    const TYPE_PINTEREST = 'PINTEREST';
    const TYPE_YOUTUBE = 'YOUTUBE';

    public $timestamps = true;

    public $urlNamespace = 'social_networks';

    public $temporalField = 'created_at';

    use SoftDeletes;

    protected $table = 'social_networks';

    protected $dates = ['deleted_at'];

    protected $fillable = ['link', 'type', 'tooltip'];


    public function buildLinkTag($tooltipPlacement = 'top')
    {
        $imgTag = $this->buildLogoImgTag($tooltipPlacement);

        return "<a data-id='$this->id' class='footer-social-network-logo' href='$this->link' target='_blank'> $imgTag </a>";
    }


    public function buildLogoImgTag($placement = 'top')
    {
        $path = $this->logoPath();
        $title = $this->tooltip ? "title='$this->tooltip'" : '';
        $tooltip = $this->tooltip ? "data-toggle='tooltip' data-placement='$placement'" : '';

        return "<img src='$path' $title $tooltip class='social-network-logo'/>";
    }


    public function logoPath()
    {
        return '/img/logos/' . strtolower($this->type) . '.png';
    }
}
