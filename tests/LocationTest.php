<?php

class LocationTest extends SapphireTest
{

    protected static $fixture_file = 'locator/tests/Locator_Test.yml';

    public function testGetCoords()
    {
        $location = $this->objFromFixture('Location', 'dynamic');
        $location->write();

        $coords = ($location->Lat && $location->Lng) ? 'true' : 'false';
        $geoCodable = Location::get()->byID($location->ID);

        $this->assertEquals($coords, $geoCodable->getCoords());
    }

    public function testFieldLabels()
    {
        $location = $this->objFromFixture('Location', 'dynamic');
        $labels = $location->FieldLabels();
        $expected = array(
            'Title' => 'Name',
            'Featured' => 'Featured',
            'Website' => 'Website',
            'Phone' => 'Phone',
            'Email' => 'Email',
            'EmailAddress' => 'Email Address',
            'ShowInLocator' => 'Show',
            'Address' => 'Address',
            'Suburb' => 'City',
            'State' => 'State',
            'Postcode' => 'Postal Code',
            'Country' => 'Country',
            'Lat' => 'Lat',
            'Lng' => 'Lng',
            'Category' => 'Category',
            'ShowInLocator.NiceAsBoolean' => 'Show',
            'Category.Name' => 'Category',
            'Featured.NiceAsBoolean' => 'Featured',
            'Coords' => 'Coords',
            'LatLngOverride' => 'Lat Lng Override',
        );
        $this->assertEquals($expected, $labels);
    }

    public function testGetCMSFields()
    {
        $object = new Location();
        $fieldset = $object->getCMSFields();
        $this->assertTrue(is_a($fieldset, 'FieldList'));
    }

    public function testValidate()
    {
    }

    public function testEmailAddress()
    {
    }

    public function testCanView()
    {
        $object = $this->objFromFixture('Location', 'dynamic');
        $object->write();

        $this->assertTrue($object->canView());

        $nullMember = Member::create();
        $nullMember->write();

        $this->assertTrue($object->canView($nullMember));

        $nullMember->delete();
    }

    public function testCanEdit()
    {
        $object = $this->objFromFixture('Location', 'dynamic');
        $object->write();

        $objectID = $object->ID;

        //test permissions per permission setting
        $create = $this->objFromFixture('Member', 'locationcreate');
        $edit = $this->objFromFixture('Member', 'locationedit');
        $delete = $this->objFromFixture('Member', 'locationdelete');

        $originalTitle = $object->Title;
        $this->assertEquals($originalTitle, 'Dynamic, Inc.');

        $this->assertTrue($object->canEdit($edit));
        $this->assertFalse($object->canEdit($create));
        $this->assertFalse($object->canEdit($delete));

        $object->Title = 'Changed Title';
        $object->write();

        $testEdit = Location::get()->byID($objectID);
        $this->assertEquals($testEdit->Title, 'Changed Title');
    }

    public function testCanDelete()
    {
        $object = $this->objFromFixture('Location', 'dynamic');
        $object->write();

        //test permissions per permission setting
        $create = $this->objFromFixture('Member', 'locationcreate');
        $edit = $this->objFromFixture('Member', 'locationedit');
        $delete = $this->objFromFixture('Member', 'locationdelete');

        $this->assertTrue($object->canDelete($delete));
        $this->assertFalse($object->canDelete($create));
        $this->assertFalse($object->canDelete($edit));

        $checkObject = $object;
        $object->delete();

        $this->assertEquals($checkObject->ID, 0);
    }

    public function testCanCreate()
    {
        $object = singleton('Location');

        //test permissions per permission setting
        $create = $this->objFromFixture('Member', 'locationcreate');
        $edit = $this->objFromFixture('Member', 'locationedit');
        $delete = $this->objFromFixture('Member', 'locationdelete');

        $this->assertTrue($object->canCreate($create));
        $this->assertFalse($object->canCreate($edit));
        $this->assertFalse($object->canCreate($delete));

        $nullMember = Member::create();
        $nullMember->write();
        $this->assertFalse($object->canCreate($nullMember));

        $nullMember->delete();
    }

    public function testProvidePermissions()
    {
    }

    public function testOnBeforeWrite()
    {
    }
}
