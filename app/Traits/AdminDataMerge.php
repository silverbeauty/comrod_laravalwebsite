<?php

namespace App\Traits;

use App\Slug;
use App\User;
use App\Image;
use App\Niche;
use App\Voter;
use App\Comment;
use App\Content;
use App\Country;
use App\OldUser;
use App\Activity;
use Carbon\Carbon;
use App\OldContent;
use App\ContentView;
use App\VehicleType;
use App\CommentReply;
use App\ContentImage;
use App\ContentNiche;
use App\LicensePlate;
use App\VehicleColor;
use App\OldLicensePlate;
use App\ContentLicensePlate;
use Illuminate\Support\Facades\DB;

trait AdminDataMerge
{
    public function getUpdateTables()
    {
        // $this->getUpdateVotersTable();
        // $this->getUpdateCommentsTable();
        // $this->getUpdateCommentsRepliesTable();
        // $this->getUpdateContents();
        // $this->getUpdateContentEmbed();
        // $this->getUpdateContentVotes();
        // $this->getUpdateContentEmbed();
        // $this->getUpdateContentType();
        $this->getUpdateContentImages();
        // $this->getUpdateContentsCategory();
        // $this->getUpdateContentNicheTable();
        // $this->getUpdateContentLicensePlatesTable();
        // $this->getUpdateContentOffenceDate();
        // $this->getUpdateContentTotalViews();
        // $this->getUpdateContentTotalComments();
        //$this->getUpdateCountryTotalContent();
        //$this->getUpdateCategoriesTotalContent();            
        //$this->getUpdateUsersTable();
        //$this->getUpdateActivitiesTable();
    }

    public function getUpdateContents()
    {
        Content::truncate();

        $old_contents = DB::connection('roadshamer')->table('content')
                        ->select(DB::raw('
                            *,
                            submitter as user_id,
                            record_num as id,
                            orig_filename as original_filename,
                            location as country_code,
                            state as region_code,
                            city as city_name,
                            date_added as created_at,
                            date_added as updated_at
                        '))->get();
        
        foreach ($old_contents as $key => $old_content) {
            $new_content = Content::find($old_content->record_num);

            //dd((array) $old_content);
            if (!$new_content) {
                Content::create((array) $old_content);
            }
        }

        Content::whereApproved(2)->update(['approved' => 1]);        
    }

    public function getUpdateContentsCategory()
    {
        ContentNiche::whereNicheId(34)->update(['niche_id' => 8]);
        ContentNiche::whereNicheId(37)->update(['niche_id' => 8]);
        ContentNiche::whereNicheId(36)->update(['niche_id' => 38]);
        ContentNiche::whereNicheId(30)->update(['niche_id' => 13]);
    }

    public function getUpdateContentOffenceDate()
    {
        //$contents = Content::all();
        $contents = Content::where('offence_date', 'like', '%2016-01-18%')->get();
        $old_contents = DB::connection('test')->table('content');
        $total_affected_rows = 0;

        foreach ($contents as $key => $content) {
            $old_content = DB::connection('test')->table('content')->whereRecordNum($content->id)->first();

            if ($old_content) {
                $content->offence_date = $old_content->offence_date .' '. $old_content->offence_time;
                $content->save();
                $total_affected_rows++;
            }
            // $pieces = explode(' ', $content->offence_date);
            // $content->offence_date = $pieces[0] .' '. $content->offence_time;
            // $content->save();
        }

        return 'Total affected rows: '.$total_affected_rows;
    }

    public function getUpdateContentEmbed()
    {
        $contents = Content::where('embed', '!=', '')->get();

        foreach ($contents as $key => $content) {
            $embed_code = $content->embed;
            preg_match_all('#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#', $embed_code, $match);
            $youtube_id = youtube_id($match[0][0]);
            $pieces = explode('?', $youtube_id);

            if ($youtube_id) {
                $content->embed_type = 'youtube';
                $content->embed_id = $pieces[0];
                $content->save();
            }
        }

        return 'done';
    }

    public function getUpdateContentVotes()
    {
        $old_contents = DB::connection('roadshamer')->table('content')->get();

        foreach ($old_contents as $key => $old_content) {
            $new_content = Content::find($old_content->record_num);

            if ($new_content) {
                $danger = intval($old_content->total_votes);
                $antisocial = intval($old_content->total_votes_2);
                $total_votes = $danger + $antisocial;
                $total_rating = ceil($total_votes / 1.5);
                $total_likes = $total_rating;
                $total_dislikes = $total_votes - $total_rating;
                $total_rating = $total_likes - $total_dislikes;
                
                $new_content->total_votes = $total_votes;
                $new_content->total_likes = $total_likes;
                $new_content->total_dislikes = $total_dislikes;
                $new_content->total_rating = $total_rating;
                $new_content->save();
            }
        }

        //dd($old_contents);
    }

    public function getUpdateContentTotalViews()
    {
        $views = DB::connection('roadshamer')->table('content_views')->get();

        foreach ($views as $view) {
            $content = Content::find($view->content);

            if ($content) {
                $content->total_views = $view->views;
                $content->save();
            }    
        }

        return 'Success';
    }

    public function getUpdateContentTotalComments()
    {
        foreach (Content::all() as $content) {
            $content->total_comments = $content->comments()->count();
            $content->save();
        }
    }

    public function getUpdateContentType()
    {
        foreach (Content::all() as $content) {
            $content->type = $content->calculated_type;
            $content->save();
        }
    }

    public function getUpdateContentImages()
    {
        //ContentImage::truncate();

        $images = DB::connection('roadshamer')->table('images')->get();

        foreach ($images as $image) {
            if (!ContentImage::whereContentId($image->gallery)->whereFilename($image->filename)->first()) {
                ContentImage::create([
                    'content_id' => $image->gallery,
                    'filename' => $image->filename
                ]);
            }
        }
    }

    public function getUpdateCountryTotalContent()
    {
        $contents = Content::select(DB::raw('count(*) as content_count, country_code'))->groupBy('country_code')->get();
        
        foreach ($contents as $content) {
            $country = Country::whereCode($content->country_code)->first();

            if ($country) {
                $country->total_content = $content->content_count;
                $country->save();
            }    
        }

        return 'Success';
    }

    public function getUpdateCategoriesTotalContent()
    {
        $content_niches = ContentNiche::select(DB::raw('count(*) as niche_count, niche_id'))->groupBy('niche_id')->get();

        foreach ($content_niches as $content) {
            $niche = Niche::find($content->niche_id);

            if ($niche) {
                $niche->total_content = $content->niche_count;
                $niche->save();
            }    
        }

        return 'Success';
    }

    public function getUpdateActivitiesTable()
    {
        Activity::truncate();

        $activities = DB::connection('roadshamer')->table('activities')->get();

        foreach ($activities as $key => $activity) {
           Activity::create([
                'id' => $activity->id,
                'user_id' => $activity->user_id,
                'type' => $activity->type,
                'sub_type' => $activity->sub_type,
                'activitable_id' => $activity->activitable_id,
                'activitable_type' => str_replace('Models', 'App', $activity->activitable_type),
                'read' => $activity->read,
                'deleted_at' => $activity->deleted_at,
                'created_at' => $activity->created_at,
                'updated_at' => $activity->updated_at
            ]);
        }
    }

    public function getUpdateLicensePlatesTable()
    {
        LicensePlate::truncate();

        $plates = DB::connection('roadshamer')->table('license_plates')->get();

        foreach ($plates as $key => $plate) {
            $car_type = VehicleType::whereName($plate->type)->first();
            $type_id = $car_type ? $car_type->id : null;

            $car_color = VehicleColor::whereName($plate->color)->first();
            $color_id = $car_color ? $car_color->id : null;

            LicensePlate::create([
                'id' => $plate->record_num,
                'name' => $plate->name,
                'country_code' => $plate->location,
                'region_code' => $plate->state,
                'type_id' => $type_id,
                'color_id' => $color_id,
                'make_id' => $plate->makeid,
                'model_id' => $plate->modelid
            ]);
        }
    }

    public function getUpdateContentImagesTable()
    {
        ContentImage::truncate();

        $images = DB::connection('roadshamer')->table('content_images')->get();

        foreach ($images as $key => $image) {
            ContentImage::create([
                'id' => $image->record_num,
                'content_id' => $image->content,
                'filename' => $image->filename,                
            ]);
        }
    }

    public function getUpdateContentLicensePlatesTable()
    {
        ContentLicensePlate::truncate();

        $plates = DB::connection('roadshamer')->table('content_license_plates')->get();

        foreach ($plates as $key => $plate) {
            ContentLicensePlate::create([
                'content_id' => $plate->content,
                'license_id' => $plate->licenseid
            ]);
        }
    }
    
    public function getUpdateVotersTable()
    {
        Voter::truncate();

        $voters = DB::connection('roadshamer')->table('voters')->get();

        foreach ($voters as $key => $voter) {
            Voter::create([
                'id' => $voter->id,
                'user_id' => $voter->user_id,
                'votable_id' => $voter->votable_id,
                'votable_type' => str_replace('Models', 'App', $voter->votable_type),
                'type' => $voter->type,
                'created_at' => $voter->created_at,
                'updated_at' => $voter->updated_at
            ]);
        }
    }

    public function getUpdateContentNicheTable()
    {
        ContentNiche::truncate();

        $niches = DB::connection('roadshamer')->table('content_niches')->get();

        foreach ($niches as $key => $niche) {
            ContentNiche::create([
                'content_id' => $niche->content,
                'niche_id' => $niche->niche
            ]);
        }
    }

    public function getUpdateCommentsTable()
    {
        Comment::truncate();

        $old_comments = DB::connection('roadshamer')->table('comments_new')->get();

        foreach ($old_comments as $key => $old_comment) {
            Comment::create([
                'id' => $old_comment->id,
                'user_id' => $old_comment->user_id,
                'body' => $old_comment->body,
                'total_votes' => $old_comment->votes,
                'total_likes' => $old_comment->likes,
                'total_dislikes' => $old_comment->dislikes,
                'commentable_id' => $old_comment->commentable_id,
                'commentable_type' => str_replace('Models', 'App', $old_comment->commentable_type),
                'ip' => $old_comment->ip,
                'status' => $old_comment->status,
                'read' => $old_comment->read,
                'created_at' => $old_comment->created_at,
                'updated_at' => $old_comment->updated_at
            ]);
        }        
    }

    public function getUpdateCommentsRepliesTable()
    {
        CommentReply::truncate();

        $old_replies = DB::connection('roadshamer')->table('comments_replies')->get();

        foreach ($old_replies as $key => $old_replies) {
            CommentReply::create([
                'id' => $old_replies->id,
                'user_id' => $old_replies->user_id,
                'comment_id' => $old_replies->comment_id,
                'body' => $old_replies->body,
                'total_votes' => $old_replies->votes,
                'total_likes' => $old_replies->likes,
                'total_dislikes' => $old_replies->dislikes,
                'ip' => $old_replies->ip,
                'parent_id' => $old_replies->parent_id,
                'status' => $old_replies->status,
                'read' => $old_replies->read,
                'created_at' => $old_replies->created_at,
                'updated_at' => $old_replies->updated_at
            ]);
        }        
    }

    public function getUpdateUsersTable()
    {
        DB::statement("SET foreign_key_checks = 0");
        Slug::truncate();
        User::truncate();

        $old_users = DB::connection('roadshamer')->table('users')->get();

        foreach ($old_users as $key => $user) {
            $extract_name = explode(' ', $user->name);
            $first_name = null;
            $last_name = null;

            if (is_array($extract_name)) {
                $first_name = isset($extract_name[0]) ? $extract_name[0] : null;
                $last_name = isset($extract_name[1]) ? $extract_name[1] : null;
            }

            $exists = User::whereId($user->record_num)
                            //->orWhere('email', $user->email)
                            ->orWhere('username', $user->username)
                            ->first();

            if (!$exists) {                
                User::create([
                    'id' => $user->record_num,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'username' => $user->username,
                    'email' => $user->email,
                    'password' => $user->password,
                    'salt' => $user->salt,
                    'gender' => $user->gender,
                    'country_code' => $user->location,
                    'birth_day' => $user->age ? Carbon::now()->subYears($user->age) : null,
                    'friendly_alerts' => $user->friendly_alerts,
                    'parental_alerts' => $user->parental_alerts,
                    'verified_email' => 1,
                    'avatar' => !empty($user->avatar) ? $user->avatar : null,
                    'registration_ip' => $user->registration_ip,
                    'last_ip' => $user->last_ip,
                    'last_login' => $user->lastlogin ? date('Y-m-d H:i:s', $user->lastlogin) : null,
                    'last_last_login' => $user->last_last_login ? date('Y-m-d H:i:s', $user->last_last_login) : null,
                    'points' => $user->points,
                    'gcm_token' => $user->gcm_token,
                    'user_agent' => $user->user_agent,
                    'old_user' => 1,
                    'deleted_at' => $user->deleted_at,
                    'created_at' => $user->date_joined,
                    'updated_at' => $user->lastlogin ? date('Y-m-d H:i:s', $user->lastlogin) : $user->date_joined,
                    'facebook_id' => $user->facebook_id,
                ]);
            } else {
                $exists->update([
                    'last_login' => !empty($user->lastlogin) ? date('Y-m-d H:i:s', $user->lastlogin) : null,
                    'last_last_login' => !empty($user->last_last_login) ? date('Y-m-d H:i:s', $user->last_last_login) : null,
                ]);
            }
        }
    }
}