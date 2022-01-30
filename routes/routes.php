<?php


RouterBets::get('/accounts',true,Accounts::class,'getAccounts',['limit' => $_GET['limit'],'page' => $_GET['page'],'checked' => $_GET['checked']]);
RouterBets::get('/account/unwatched',false,AccountData::class,'getUnwatchedAccountData');
RouterBets::get('/stats',true,AccountsStats::class,'getStats');
RouterBets::get('/freebets/info',true,FreeBetsData::class,'getFreeBetsInfo');

RouterBets::post('/account/delete',true,AccountData::class,'deleteAccountData');
RouterBets::post('/account/edit',true,AccountData::class,'editAccountData');

RouterBets::enable();
