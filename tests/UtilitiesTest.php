<?php

use Rizkhal\Inertable\Utils\ColumnAttributes;

it('will parse fields', function () {
    $this->assertEquals('id', ColumnAttributes::parseField('users.id'));
});

it('will parse relations', function () {
    $this->assertEquals('users', ColumnAttributes::parseRelation('users.id'));
});

it('should has match', function () {
    $this->assertTrue(ColumnAttributes::hasMatch('id', ['id', 'email']));
    $this->assertTrue(ColumnAttributes::hasMatch('email', ['id', 'email']));
});
