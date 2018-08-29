<?php

namespace Soumen\Auction\Traits;

use Soumen\Auction\Models\Bid;

trait CanBeAuctioned
{
    /**
     * Polymorphic relationship.
     *
     * @author Soumen Dey
     */
    public function bids()
    {
        return $this->morphMany(Bid::class, 'model');
    }

    /**
     * Place a bid on a model.
     *
     * @return Boolean | App\Bid
     * @author Soumen Dey
     */
    public function placeBid($amount)
    {
        if (!$this->isValidAmount($amount)) {
            return false;
        }

        return $this->bids()->create($this->getCreateValues($amount));
    }

    /**
     * 
     *
     * @return 
     * @author Soumen Dey
     */
    public function isValidAmount($amount)
    {
        $highestBid = $this->getHighestBidAmount();

        // a person cannot place a bid below the increment value
        if (!$this->isAmountWithinIncrementRange($highestBid)) {
            return false;
        }
        
        // a person cannot place a bid below the highest value
        if ($amount <= $highestBid) {
            return false;
        }
        
        // a person cannot bid successively
        if ($this->isSuccessiveBidAllowed() && $this->isLastBidder()) {
            return false;
        }

        return true;
    }

    /**
     * 
     *
     * @return 
     * @author Soumen Dey
     */
    public function calculateBidIncrementValue($bid)
    {
        // custom logic for increment value taking into account the increment factor
    }

    /**
     * 
     *
     * @return 
     * @author Soumen Dey
     */
    public function isAmountWithinIncrementRange($highestBid)
    {
        $increment = $this->calculateBidIncrementValue($highestBid);

        if (!$increment) {
            return true;
        }

        return $highestBid >= $increment;
    }

    /**
     * Get the increment factor.
     *
     * @return Integer
     * @author Soumen Dey
     */
    public function getIncrementFactor()
    {
        return 5;
    }

    /**
     * Determines if successive bidding is allowed.
     *
     * @return Boolean
     * @author Soumen Dey
     */
    public function isSuccessiveBidAllowed()
    {
        return false;
    }

    /**
     * Get the last bid on the model.
     *
     * @return App\Bid
     * @author Soumen Dey
     */
    public function getLastBid()
    {
        return $this->bids->sortByDesc('id')->first();
    }

    /**
     * Get the last bid amount.
     *
     * @return Integer | Null
     * @author Soumen Dey
     */
    public function getLastBidAmount()
    {
        $bid = $this->getLastBid();

        if ($bid) {
            return (int) $bid->bid_value;
        }

        return null;
    }

    /**
     * Alias for getLastBid()
     *
     * @return App\Bid
     * @author Soumen Dey
     */
    public function getCurrentBid()
    {
        return $this->getLastBid();
    }

    /**
     * Alias for getLastBidAmount()
     *
     * @return App\Bid
     * @author Soumen Dey
     */
    public function getCurrentBidAmount()
    {
        return $this->getLastBidAmount();
    }

    /**
     * Get the highest bid.
     *
     * @return App\Bid
     * @author Soumen Dey
     */
    public function getHighestBid()
    {
        return $this->bids->sortByDesc('bid_value')->first();
    }

    /**
     * Get the highest bid amount.
     *
     * @return Integer | Null
     * @author Soumen Dey
     */
    public function getHighestBidAmount()
    {
        $bid = $this->getHighestBid();
        
        if ($bid) {
            return (int) $bid->bid_value;
        }

        return null;
    }

    /**
     * Get the user of who is the highest bidder.
     *
     * @return Array
     * @author Soumen Dey
     */
    public function getHighestBidder()
    {
        $bid = $this->getHighestBid();

        return $bid->user->setAttribute('bid_value', (int) $bid->bid_value);
    }

    /**
     * Get the user of who is the last bidder.
     *
     * @return Array
     * @author Soumen Dey
     */
    public function getLastBidder()
    {
        $bid = $this->getLastBid();

        return $bid->user->setAttribute('bid_value', (int) $bid->bid_value);        
    }
    
    /**
     * 
     *
     * @return 
     * @author Soumen Dey
     */
    public function isLastBidder($user = null)
    {
        if (!$user) {
            $user = auth()->user();
        }

        if ($this->getLastBidder()->id === auth()->user()->id) {
            return true;
        }

        return false;
    }

    /**
     * Get the values to be inserted into the Bid model.
     *
     * @return Array
     * @author Soumen Dey
     */
    public function getCreateValues($amount)
    {
        return [
            'bid_value' => $amount,
            'user_id' => 1 // temporary value, should contain the authenticated user id
        ];
    }
}