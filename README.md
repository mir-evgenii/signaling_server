## WebRTC signaling server.

Signaling server for exchanging SDP datagram between clients to establish peer-to-peer connection via [WebRTC](https://webrtc.org/). 
Clients use their public PGP keys as names and sign their messages with private PGP keys.
Signaling server uses [Yii 2](http://www.yiiframework.com/) Basic Project Template.

---

### API

---

1. Connect to signaling server.

Request: `host:port/client/add?key=123`

- key - yours public key;

Response success: `{'message': 'isOnline'}`

Response error: `{'message': 'Error'}`

---

2. Get users connected to the signaling server.

Request: `host:port/client/get?keys=123;345;456`

- keys - public keys yours friends;

Response success: `{'online_users': {123, 345}}` or `{'online_users': {}}`

Response error: `{'message': 'Error'}`

---

3. Send message or SDP datagram.

Request: `host:port/message/send?content=text&sender=123&recipient=345&date=2020-04-20%2010:00:00&sign=1234314`

- content - message or SDP datagram;
- sender - your public key;
- recipient - public key your friend;
- date - now date;
- sign - signing the message with your private key;

Response success: `{'message': 'send'}`

Response error: `{'message': 'Error, not save message.'}` or `{'message': 'Error, not verify sign.'}`

---

4. Get messages or SDP datagram.

Request: `host:port/message/get?key=345`

- key - your public key;

Response success: `{'messages-for-client': {{'content': 'SDP', 'sender': '123', 'recipient': '345', 'date': '2020-04-27 10:00:00', 'sign': '1234314'}}}` or `{'messages-for-client': {}}`

Response error: `{'message': 'Error'}`

---

5 Disconnect with the signaling server.

Request: `host:port/client/del?key=123`

- key - your public key;

Response success: `{'message': 'isOffline'}`

Response error: `{'message': 'Error'}`

---




