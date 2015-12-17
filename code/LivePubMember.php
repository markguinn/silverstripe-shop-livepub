<?php
/**
 * Stores a little extra info about the user in the session so it
 * can be used by cached pages.
 *
 * @author Mark Guinn <mark@adaircreative.com>
 * @date 05.28.2014
 * @package shop_livepub
 */
class LivePubMember extends DataExtension
{
    /**
     * This is a hook that's called whenever a new user logs in.
     * This session variable is used in connection with livepub
     */
    public function memberLoggedIn()
    {
        Session::set('IsCmsAdmin', Permission::check('CMS_ACCESS_CMSMain'));
        Session::set('LoggedInMember', $this->dataForSession());
    }

    public function memberAutoLoggedIn()
    {
        Session::set('IsCmsAdmin', Permission::check('CMS_ACCESS_CMSMain'));
        Session::set('LoggedInMember', $this->dataForSession());
    }

    public function memberLoggedOut()
    {
        Session::clear('IsCmsAdmin');
        Session::clear('LoggedInMember');
    }


    /**
     * @return array
     */
    protected function dataForSession()
    {
        return array(
            'ID'        => $this->owner->ID,
            'Groups'    => $this->owner->Groups()->column('Code'),
            'Email'     => $this->owner->Email,
            'FirstName' => $this->owner->FirstName,
            'Surname'   => $this->owner->Surname,
        );
    }
}
