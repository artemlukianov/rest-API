## Rest api test task

Используется Symfony, postgres, docker

## Requirements

Docker, docker-compose

## Installation

clone `https://github.com/artemlukianov/rest-API.git`

init `./bin/init.sh`

## Usage

Enter to container `docker-compose exec app bash`

## Endpoints list

`POST     /api/logout`           
`POST     /api/finance/transfer`   
`POST     api/register`  
`GET      /api/user/info   `         
`POST     /api/login_check     `     
`POST     /api/token/refresh`

## Test curls
-----------------
Register user:
`curl --header "Content-Type: application/json"   --request POST   --data '{"username":"tester","password":"qwerasdf", "email":"test@gmail.com"}'   http://localhost:8080/api/register` <br />
Response:<br />
`{"username":"tester1","email":"t***1@gmail.com","finance":{"balance":0},"transactionsHistory":[]}`<br />
-----------------
Login: <br />
`curl --header "Content-Type: application/json"   --request POST   --data '{"username":"tester","password":"qwerasdf", "email":"test@gmail.com"}'   http://localhost:8080/api/login_check` <br />
Response:
`{"token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2MzUxNTAzMzksImV4cCI6MTYzNTE1MzkzOSwicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoidGVzdGVyIiwiaGFzaCI6IjYxNzY2OWI4MDhlYTkifQ.SKx5MVt4pMKar9v1geo9uibHyoBakBpIKK2s3PsXIoarDGA1R9Im8Y_-cczHC5zXgznNFyj57-n2lNA2rRriounmkqZt7EkhwnJlSdeZGwMCd2DwKWLWCm8aWAvSX-8mWQUtgmyviRgFLeluYR4YDTl9K_JhL4X4ngQCkgzzBdgQoyijm1YKNTiEQPfQuUaA9VU1Pm4TKOAONRjW83RHBvVuwXNTND09f0znbZqGZ1LbNV0DbDxaAvUnehGDfcppRCjtBrOL9WHHadGXxQsZJQuqLEbJdhWWiMely_UTONaqA8k30AAp9xAQlVEM1NWz4ybpQiWwrDRud6cwAqeX3rVYm_AjXjzJFJORk5yJ5Ju6-PmxCyHSvZ2Qq2ImnnGbrOszXSBTpVT9zBCgXjzY4SYPf6zFSk-2LJJTT8vzj9ZamMD4xOHKGxBubsYK-25ZQ-uVyr7pG3Tn-u8yhVZLDal-3rRt3wb4rPFsvFx36x7WUfwPgpIaAyEQ-Z3mIdMD_Kn2jVUpWBgsAnnGqj_yBpTv5I0Yv-FixJZ4Nu8hsSD3q9rJRpzbqsOkIWE_nQd0cnbnsKc9uzudcau4dQRAN8vwbEnQXk9If1z-8kzaICnSkG50Mf6beAstMPKbieLoaz2GsVN5YtG3Qk88gn3z0MXkUtqWvgq4Z-0nr1ok3mM","refresh_token":"347a28c8ccda6914ebab1d259f18658e3daeb2b8332097a5755e65fbd4eac639573f9f32c968538512413b234fd5c9a07aaaa4b4e40cf78c8ab4548704fbe3fc"}
` <br />
-----------------
User info
`curl --header "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2MzUxNTE2ODgsImV4cCI6MTYzNTE1NTI4OCwicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoidGVzdGVyMSIsImhhc2giOiI2MTc2NjljZTgyYzgyIn0.h5BR9Z45ZLZCBArjyFOJrO_CdMcWjxKOFarCdK_Pxyz-viu2P-aPivMCzbdYTRCc_7mTHas16azbMVZePsHVTehQ235EDlANVY2uIqhoVnLx5XQEW7pVKILjRRMH14vuRz2Am-xrZgNoocQ-_hZ3cVZndd6UQm1si0RqCTWQ-ogmcPl4pXIhBGPrl5Hq-2CuDjKvsZ_qZKb61TAQ_WOcowcIU4quyYTDeEwLLS43lO2ZFv9MVBgetaYwS6nxgXlzxxdQKP2fcY03ahbyAexk-kYGNwYWYtU0qH1vJpLNuD8Ej-vKWCjfHY3WDTju896-HVqMMZP71AV3W6atVb_BPbUxCCH-tWEpylPbXTrSArsqHyxjHKrxqWOgfeZEI-HCfVfSIwXzb_8_XSKY8GixKo7gEIk3wlxik_yFCBgwEjP1w-IlTacnDgN90PMntgnOzQawZD89PeBdOAwRlappFWJRk9TJrjg_7Hb4Imbx_1x87mx4QW5DLFTLQv_Oz-b6jG5lSXgTPXSSF5VnKeTQG9uBvQjcw-7VsV3vio5eRxiTHuBK1sRLOGkum9z_K06zApHPgM02LYGAp5YecKVbb9_PheiZ5kSMpKqryF1Y8kJV9xTLEMiqDvV0YDh_4Dcit7Uo3kNbL0o2wevkn6sHbVznXeXvWSsot70DmCJX2Hk" --request GET http://localhost:8080/api/user/info
` <br />
Response:
`{"username":"aaaaamss","email":"t**t@gmail.com","finance":{"balance":0},"transactionsHistory":[]}`

-----------------
Top up balance commend
`bin/console app:top-up-user-balance test@gmail.com 1.2223`

-----------------
Transfer
`curl --header "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2MzUxNTAzMzksImV4cCI6MTYzNTE1MzkzOSwicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoidGVzdGVyIiwiaGFzaCI6IjYxNzY2OWI4MDhlYTkifQ.SKx5MVt4pMKar9v1geo9uibHyoBakBpIKK2s3PsXIoarDGA1R9Im8Y_-cczHC5zXgznNFyj57-n2lNA2rRriounmkqZt7EkhwnJlSdeZGwMCd2DwKWLWCm8aWAvSX-8mWQUtgmyviRgFLeluYR4YDTl9K_JhL4X4ngQCkgzzBdgQoyijm1YKNTiEQPfQuUaA9VU1Pm4TKOAONRjW83RHBvVuwXNTND09f0znbZqGZ1LbNV0DbDxaAvUnehGDfcppRCjtBrOL9WHHadGXxQsZJQuqLEbJdhWWiMely_UTONaqA8k30AAp9xAQlVEM1NWz4ybpQiWwrDRud6cwAqeX3rVYm_AjXjzJFJORk5yJ5Ju6-PmxCyHSvZ2Qq2ImnnGbrOszXSBTpVT9zBCgXjzY4SYPf6zFSk-2LJJTT8vzj9ZamMD4xOHKGxBubsYK-25ZQ-uVyr7pG3Tn-u8yhVZLDal-3rRt3wb4rPFsvFx36x7WUfwPgpIaAyEQ-Z3mIdMD_Kn2jVUpWBgsAnnGqj_yBpTv5I0Yv-FixJZ4Nu8hsSD3q9rJRpzbqsOkIWE_nQd0cnbnsKc9uzudcau4dQRAN8vwbEnQXk9If1z-8kzaICnSkG50Mf6beAstMPKbieLoaz2GsVN5YtG3Qk88gn3z0MXkUtqWvgq4Z-0nr1ok3mM"   --request POST   --data '{"username":"tester1","amount": 1}' http://localhost:8080/api/finance/transfer
`<br />
Response:
`{"amount":1,"sender":{"username":"aaaaamss","email":"t**t@gmail.com"},"recipientUsername":"tester1","createdAt":"2021-10-25T08:18:15+00:00"}
`
-----------------
Logout
`curl --header "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2MzUxNTE2ODgsImV4cCI6MTYzNTE1NTI4OCwicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoidGVzdGVyMSIsImhhc2giOiI2MTc2NjljZTgyYzgyIn0.h5BR9Z45ZLZCBArjyFOJrO_CdMcWjxKOFarCdK_Pxyz-viu2P-aPivMCzbdYTRCc_7mTHas16azbMVZePsHVTehQ235EDlANVY2uIqhoVnLx5XQEW7pVKILjRRMH14vuRz2Am-xrZgNoocQ-_hZ3cVZndd6UQm1si0RqCTWQ-ogmcPl4pXIhBGPrl5Hq-2CuDjKvsZ_qZKb61TAQ_WOcowcIU4quyYTDeEwLLS43lO2ZFv9MVBgetaYwS6nxgXlzxxdQKP2fcY03ahbyAexk-kYGNwYWYtU0qH1vJpLNuD8Ej-vKWCjfHY3WDTju896-HVqMMZP71AV3W6atVb_BPbUxCCH-tWEpylPbXTrSArsqHyxjHKrxqWOgfeZEI-HCfVfSIwXzb_8_XSKY8GixKo7gEIk3wlxik_yFCBgwEjP1w-IlTacnDgN90PMntgnOzQawZD89PeBdOAwRlappFWJRk9TJrjg_7Hb4Imbx_1x87mx4QW5DLFTLQv_Oz-b6jG5lSXgTPXSSF5VnKeTQG9uBvQjcw-7VsV3vio5eRxiTHuBK1sRLOGkum9z_K06zApHPgM02LYGAp5YecKVbb9_PheiZ5kSMpKqryF1Y8kJV9xTLEMiqDvV0YDh_4Dcit7Uo3kNbL0o2wevkn6sHbVznXeXvWSsot70DmCJX2Hk"   --request POST http://localhost:8080/api/logout
`<br />
Response: 
`{"message":"User logged out"}`

