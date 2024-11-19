## Install
composer require jsadways/dataapi

## Edit .env file
if you use the old repository version add this to .env file
```
REPOSITORY_VERSION=0
```

## The defined route url in this package
1. Used in local backend, to receive request from frontend and pass request to the second url below in another system

`POST` `/api/data_api/fetch`

`parameters`
```
{
    system : 'string, the system name you want to get data, which defined in HR system',
    repository : 'string, the repository name you what to get data in the target system',
    condition : 'json, the json condition you wnat to filter out the data, the struce must be the scopFilter package defined'
}
```

`response`
```
{
    status_code : 'integer, 200 for success, others for fail',
    data : 'json, the data you filter out from other system'
}
```

2. Used in other system backend, for filter out data using repository

<span style="background-color:red">
***We doesn't recommend using this url directly***
</span>

`GET` `/api/data_api/get`

`parameters`
```
{
    repository : 'string, the repository name you what to get data in the target system',
    condition : 'json, the json condition you wnat to filter out the data, the struce must be the scopFilter package defined'
}
```

`response`
```
{
    status_code : 'integer, 200 for success, others for fail',
    data : 'json, the data you filter out from other system'
}
```

## Examples
`code`
```
axios.post('local_backend/api/data_api/fetch',{
    system: 'crm',
    repository: 'customer',
    condition: '{"filter":{"id_number_eq":"27743336"},"per_page":"0"}'
})
```

`description`

```
frontend post to 'local_backend/api/data_api/fetch', 
to get customer data from crm system, 
where id_number column equals to '27743336'
```

`response`

```
{   "status_code":200,
    "data":
    [
        {
            "id":1,
            "created_at":"2024-09-19T08:43:00.000000Z",
            "name":"JS-Adways Group",
            "short_name":"js",
            "en_name":"js adways",
            "id_number":"27743336",
            "zip_code":"110",
            "address":"R.O.C",
            "finance_email":null,
            "type":1,
            "memo":null,
            "contact_list":[],
            "identity_list":
            [
                {
                    "id":1,
                    "created_at":"2024-09-19T08:43:00.000000Z",
                    "customer_id":1,
                    "identity":1
                },
                {
                    "id":2,
                    "created_at":"2024-09-19T08:43:00.000000Z",
                    "customer_id":1,
                    "identity":2
                }
            ]
        }
    ]
}
```
