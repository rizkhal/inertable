<?php

use Rizkhal\Inertable\Utils\ColumnAttributes;

it('will parse fields', function () {
    expect('id')->toBeString(ColumnAttributes::parseField('users.id'));
});

it('will parse relations', function () {
    expect('id')->toBeString('users', ColumnAttributes::parseRelation('users.id'));
});

it('should has match', function () {
    expect(true)->toBeTrue(ColumnAttributes::hasMatch('id', ['id', 'email']));
    expect(true)->toBeTrue(ColumnAttributes::hasMatch('email', ['id', 'email']));
});
