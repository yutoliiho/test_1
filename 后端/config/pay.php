<?php

return [
    'mch_id'     =>  '100002',
    'mch_key'    =>  'ee6ee048ff5e2a7d1f19411686448f02',
    'private_key'   =>  'MIIEvAIBADANBgkqhkiG9w0BAQEFAASCBKYwggSiAgEAAoIBAQChSR7MsCB74um7/jjYDiPvFDlVwJd6dbj30Q4lDGOt0pGvsX4hc4o5fR7UT9i7IG3AYq11J42aK/sVeUFOH7FUjQRcoYfVUu3bzj//V2qNuhTrNhqzHbMDsXuWfxbjbwwsvoTvbfZhkNOth7bXjB+KvVxmmHdzeUL0CVImfmnM9dtxGSHtsZV5tB04XIduQMIkDSwv2LDuLe/48JkoQNSiE59QoyGjkNZH+3IVWu3scxZ7hOZyRr9F0XKYQg2l5RxKPEGt+XCGJEgvQip3l7C/Y6//2WfLiZ7If4FjYdJNNh56ldAhi8oWVykNn0vn6Ch2amCwLK/iKYD3Y9nN/Yh/AgMBAAECggEAM1awHB2QKX8gQXv5oiRWIdsBKR+l2BAy8Yc1Bmv8Kq9VOmS4LnO1svj14EUOSvpWlR+T8S/G7iVDxiETvYdvDefZVJcCQtAj8IylaGTuAPETiY9uTkeM3QcYvN31bi3B5Vg7vm71Nzc/egQyGkh7HdGK4Ql1NGeL/VweLyycBuZUZyKznP4G4KM7wApEcaTuoOJCToIUKSQvDTVoUttrxjWHAYm62gI/pk7Y30dqkw9nWwsIjbYLcFFzBkWC+W0ddj5sMCIQ+EFQnCQEYcvijclGwh55M1LOFys8IeALL460M0GNkPHPVomajKk0D9vbt62/SZNDJ7CIiQ5aYP7POQKBgQDwOY7iEUuVlB9k/xKJ1IOS9VWn2M4GMif1BoxAvlOHjkwxJVei28HLOxsr2/uZGkbYSReLz1xp9+MZvZxgQtZHFx8FoQoHX+XdmcEGCEeN7U0IxnHXIKnkvWctw63z8a6e1O48y682wwRH0YIWR36ZyCCqP8Q5ghput1KOSUwUXQKBgQCr4IIBhkFoL5P0OqOBuyZ1vBm8wYGYmBy0gKCtxcJd7kwrtGwSY0P1uj6d8NGLvkfZZEhGHwlK+r4XLeqXl9mGob65kip8Rut8X1RYHP29UCuIcSPI2Y4wPqT7MU3gsa2Rg+LJ5sxP4D2M7+80zbuTB9p4Vx8hSKkaWsjQH0DCiwKBgC56dHK49e7S4eAgme2g+HQOk6wN/o6kVabKxYghSvgHSCaaGwKfkjdIEFHEFkHhG6PtQGkEjdTS6VWpof/d7qeCibYFGnOi0k612OrZ3z5Ok4EHJC+DWluvaa8pFRcFw8tnV1Db9+KYiNN8bbbxzkTiu6809zpJOeQCBC8Tb2zhAoGAcGgy/iY8rpO3MpoLBzRLkeJD/tObGx4YX+BjtWJJnL7VaBvmNhxffNyiSQ8PLFJ0kPNp5Ro1LKlSGry32Q7Bf7BWmOzEBmUnaz65XasQM3i0D9bWrWvC90BxC6sSIKpzNmDHuH3OD0s7VeoxShpm22Dee6eWv2DS316SSLK32sMCgYBhq6CiekCWIGday10YhtWK51ExNCV2IZVsMRFCDTBTHL6oqR4sdY8TLZwKvx+MrgxUmZZcEc3vivBez52T9zqBto1a4cIllrLKUIZ6br8WrOpIC9Wn1RIOBieEYMHVqc9GW5Skn45g8OIyI4S6/xZtIqdUWRTkhVAvA4KnxhWAkw==',
    'cm_public_key'    =>  'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAxV1hB4NP1NFgEM0mrx34z8gJMPBIhvDjAJcnMozk3jmUY9PkB7lZyfD6Fb+Xq21jIPX5zF4ggeYoK5keUH6TW9eJEr5JOqDl2YgKAdLfxLuJ4r8X1S3wflVp2/BURIbP1VGh6qNAxS3o8miL7x5BZ+jOhs4/LCq8YkncZioui5eAQ+/BoE++uM5IeSWZEVf8JsGo+MrOG2E/eOqetrB08Tm68igM6OMbKr05HKupcZm63zzDIHRJGKRjvdFjVoVznGsAC3phyh3bzYrjxykH00mLyw39/77MiBMp/uWVMh6wwiAjY2B25IKXXGCd0JSYvlpJWtCKbxlcAGDWSWkS0wIDAQAB',
    'notify_url' => 'http://' . config('app.url') . '/api/pay/notify',
    'return_url' => 'http://' . config('app.url') . '/api/pay/return',
];
