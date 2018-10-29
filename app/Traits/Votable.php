<?php

namespace App\Traits;

use App\User;
use App\Voter;

trait Votable
{
    public function likes()
    {
        return $this->morphMany(\App\Voter::class, 'votable')->whereType('like');
    }

    public function dislikes()
    {
        return $this->morphMany(\App\Voter::class, 'votable')->whereType('dislike');
    }

    public function voters()
    {
        return $this->morphMany(\App\Voter::class, 'votable');
    }

    public function voter(User $user)
    {
        return $this->voters()->whereUserId($user->id)->first();
    }

    public function handleLikeDislike(User $user, $type)
    {
        $voter = $this->voter($user);

        if ($voter) {

            if ($voter->type == $type) {
                $voter->type = 'neutral';

                if ($type == 'like') {
                    $this->total_likes = $this->total_likes - 1;
                } else {
                    $this->total_dislikes = $this->total_dislikes - 1;
                }              
            } else {            
                if ($voter->type == 'dislike' && $type == 'like') {                    
                    $this->total_likes = $this->total_likes + 1;
                    $this->total_dislikes = $this->total_dislikes - 1;
                } elseif ($voter->type == 'like' && $type == 'dislike') {
                    $this->total_likes = $this->total_likes - 1;
                    $this->total_dislikes = $this->total_dislikes + 1;
                } else {
                    if ($type == 'like') {                    
                        $this->total_likes = $this->total_likes + 1;                        
                    } else {
                        $this->total_dislikes = $this->total_dislikes + 1;
                    }
                }
                
                $voter->type = $type;
            }

            $voter->save();

        } else {
            $this->total_votes = $this->total_votes + 1;

            if ($type == 'like') {
                $this->total_likes = $this->total_likes + 1;                
            } else {
                $this->total_dislikes = $this->total_dislikes + 1;
            }

            $this->voters()->save(new Voter(['user_id' => $user->id, 'type' => $type]));
        }

        $this->save();

        return $this;
    }   
}