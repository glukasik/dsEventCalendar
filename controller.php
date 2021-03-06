<?php
defined('C5_EXECUTE') or die(_("Access Denied."));

class dsEventCalendarPackage extends Package
{


    protected $pkgHandle = 'dsEventCalendar';
    protected $appVersionRequired = '5.5.0';
    protected $pkgVersion = '2.1.5';

    public function getPackageDescription()
    {
        return t('Event Calendar - you can add, edit and remove one day events on your page');
    }

    public function getPackageName()
    {
        return t('Event Calendar');
    }

    public function install()
    {
        $pkg = parent::install();
        BlockType::installBlockTypeFromPackage('event_calendar', $pkg);
        $this->installSP($pkg);
        $this->installSettings();
    }

    public function upgrade()
    {
        $currentVersion = $this->getPackageVersion();
        parent::upgrade();
        $this->installSP($this, $currentVersion);
        $this->installSettings();
    }


    private function installSP($pkg)
    {
        Loader::model('single_page');

        $p1 = SinglePage::add('/dashboard/event_calendar', $pkg);
        if (is_object($p1)) {
            $p1->update(array('cName' => t('Event Calendar'), 'cDescription' => ''));
        }

        $p2 = SinglePage::add('/dashboard/event_calendar/list_calendar', $pkg);
        if (is_object($p2)) {
            $p2->update(array('cName' => t('Calendars list'), 'cDescription' => ''));
        }

        $p3 = SinglePage::add('/dashboard/event_calendar/calendar', $pkg);
        if (is_object($p3)) {
            $p3->update(array('cName' => t('Add / edit calendar'), 'cDescription' => ''));
        }

        $p4 = SinglePage::add('/dashboard/event_calendar/list_event', $pkg);
        if (is_object($p4)) {
            $p4->update(array('cName' => t('Events list'), 'cDescription' => ''));
        }

        $p5 = SinglePage::add('/dashboard/event_calendar/event', $pkg);
        if (is_object($p5)) {
            $p5->update(array('cName' => t('Add / edit event'), 'cDescription' => ''));
        }

        $p6 = SinglePage::add('/dashboard/event_calendar/types', $pkg);
        if (is_object($p6)) {
            $p6->update(array('cName' => t('Type of events'), 'cDescription' => ''));
        }

        $p7 = SinglePage::add('/dashboard/event_calendar/settings', $pkg);
        if (is_object($p7)) {
            $p7->update(array('cName' => t('Settings'), 'cDescription' => ''));
        }
    }

    private function installSettings()
    {
        $db = Loader::db();

        $sql = "INSERT IGNORE INTO dsEventCalendarSettings SET opt= 'lang' , value='en-gb'";
        $db->Execute($sql);

        $sql = "INSERT IGNORE INTO dsEventCalendarSettings SET opt= 'formatTitle' , value='MMMM YYYY'";
        $db->Execute($sql);

        $sql = "INSERT IGNORE INTO dsEventCalendarSettings SET opt= 'formatEvent' , value='DD MMMM YYYY'";
        $db->Execute($sql);

        $sql = "INSERT IGNORE INTO dsEventCalendarSettings SET opt= 'startFrom' , value='1'";
        $db->Execute($sql);

        $sql = "INSERT IGNORE INTO dsEventCalendarSettings SET opt= 'eventsInDay' , value='3'";
        $db->Execute($sql);

        $sql = "INSERT IGNORE INTO dsEventCalendarSettings SET opt= 'default_color' , value='#808080'";
        $db->Execute($sql);

        $sql = "INSERT IGNORE INTO dsEventCalendarSettings SET opt= 'default_name' , value='Default'";
        $db->Execute($sql);
    }
}

?>
