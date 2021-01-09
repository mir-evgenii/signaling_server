<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Page Title</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>

    <!-- Vue -->
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>

    <!-- Bootstrap -->
    <!-- Load required Bootstrap and BootstrapVue CSS -->
    <link type="text/css" rel="stylesheet" href="https://unpkg.com/bootstrap/dist/css/bootstrap.min.css" />
    <link type="text/css" rel="stylesheet" href="https://unpkg.com/bootstrap-vue@latest/dist/bootstrap-vue.min.css" />

    <!-- Load polyfills to support older browsers -->
    <script src="https://polyfill.io/v3/polyfill.min.js?features=es2015%2CIntersectionObserver" crossorigin="anonymous"></script>

    <!-- Load Vue followed by BootstrapVue -->
    <script src="https://unpkg.com/vue@latest/dist/vue.min.js"></script>
    <script src="https://unpkg.com/bootstrap-vue@latest/dist/bootstrap-vue.min.js"></script>

    <!-- Load the following for BootstrapVueIcons support -->
    <script src="https://unpkg.com/bootstrap-vue@latest/dist/bootstrap-vue-icons.min.js"></script>

    <!-- Mobile detect -->
    <script src="https://cdn.jsdelivr.net/npm/mobile-detect@1.4.4/mobile-detect.min.js"></script>

    <!-- Crypto -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jsrsasign/8.0.20/jsrsasign-all-min.js"></script>
</head>

<body>
    <div id="app">
    <b-container class="bv-example-row">

        <!-- Modal menu -->
        <b-modal id="modal-menu" centered title="Menu" hide-footer>
        <b-container class="bv-example-row">
            <b-row class="mt-2 mb-2">
            <b-button v-b-modal.modal-add-frend><b-icon-person-plus-fill></b-icon-person-plus-fill></b-button>
            <b-button v-if="frend" v-b-modal.modal-edit-frend><b-icon-person-lines-fill></b-icon-person-lines-fill></b-button>
            <b-button v-if="frend" v-b-modal.modal-del-frend><b-icon-person-x-fill></b-icon-person-x-fill></b-button>
            <b-button v-if="frend" v-b-modal.modal-del-frend><b-icon-trash-fill></b-icon-trash-fill></b-button>
            </b-row>
            <b-row class="mb-2">
            <frend-list 
                v-for="item in frendsList" 
                v-bind:frend="item"
                v-bind:key="item.id">
            </frend-list>
            </b-row>
        </b-container>
        </b-modal>
        
        <b-modal id="modal-add-frend" centered title="Add frend" @show="resetModal" @hidden="resetModal" @ok="handleOk">
            <form ref="form" @submit.stop.prevent="handleSubmit">
                <b-form-group
                :state="nameState"
                label="Name"
                label-for="name-input"
                invalid-feedback="Name is required"
                >
                <b-form-input
                    id="name-input"
                    v-model="name"
                    :state="nameState"
                    required
                ></b-form-input>

                </b-form-group>
                <b-form-group
                :state="keyState"
                label="Key"
                label-for="key-input"
                invalid-feedback="Key is required"
                >
                <b-form-input
                    id="key-input"
                    v-model="key"
                    :state="keyState"
                    required
                ></b-form-input>
                </b-form-group>
            </form>
        </b-modal>

        <b-modal id="modal-edit-frend" centered ok-title="Edit" ok-variant="success" title="Edit frend" @show="resetModal" @hidden="resetModal" @ok="handleEdit">
            <p>Edit frend {{ frend.name }}</p>
            <form ref="form" @submit.stop.prevent="handleSubmit">
                <b-form-group
                :state="nameState"
                label="Name"
                label-for="name-input"
                invalid-feedback="Name is required"
                >
                <b-form-input
                    id="name-input"
                    v-model="frend.name"
                    :state="nameState"
                    required
                ></b-form-input>
                </b-form-group>
            </form>
        </b-modal>

        <b-modal id="modal-del-frend" ok-title="Delete" ok-variant="danger" centered title="Delete frend" @ok="handleDel">
            <p class="my-4">You delete frend {{ frend.name }}!</p>
        </b-modal>

        <!-- Modal call -->
        <b-modal id="modal-call" size="xl" centered title="Call" hide-footer>
            <b-row class="mb-2">
                <b-col cols="5"></b-col>
                <b-col cols="2"><h1><b-icon-person-circle></b-icon-person-circle></h1></b-col>
                <b-col cols="5"></b-col>
            </b-row>
            <b-row class="mb-2">
                <b-col cols="5"></b-col>
                <b-col cols="2"><h1>{{ frend.name }}</h1></b-col>
                <b-col cols="5"></b-col>
            </b-row>
            <b-row class="mb-2">
                <b-col cols="5"></b-col>
                <b-col cols="2"><b-button pill variant="outline-danger" size="lg"><b-icon-telephone-x-fill></b-icon-telephone-x-fill></b-button></b-col>
                <b-col cols="5"></b-col>
            </b-row>
        </b-modal>

        <!-- Modal video-call -->
        <b-modal id="modal-video-call" size="xl" centered title="Video-call" hide-footer>
            <b-row class="mb-2">
                <b-col cols="5"></b-col>
                <b-col cols="2"><h1>{{ frend.name }}</h1></b-col>
                <b-col cols="5"></b-col>
            </b-row>

            <video id="localVideo" autoplay muted></video>
            <video id="remoteVideo" autoplay></video>
            
            <b-row class="mb-2">
                <b-col cols="5"></b-col>
                <b-col cols="2"><b-button pill variant="outline-danger" size="lg"><b-icon-telephone-x-fill></b-icon-telephone-x-fill></b-button></b-col>
                <b-col cols="5"></b-col>
            </b-row>
        </b-modal>

        <!-- Nav bar mobile -->
        <b-navbar v-if="isMobile" sticky="true">
            <b-navbar-nav>
                <b-button-group>
                <b-button v-if="frend" v-on:click="app.back()"><b-icon-arrow-left></b-icon-arrow-left></b-button>
                <b-button v-b-modal.modal-add-frend><b-icon-person-plus-fill></b-icon-person-plus-fill></b-button>
                <b-button v-if="frend" v-b-modal.modal-edit-frend><b-icon-person-lines-fill></b-icon-person-lines-fill></b-button>
                <b-button v-if="frend" v-b-modal.modal-del-frend><b-icon-person-x-fill></b-icon-person-x-fill></b-button>
                <b-button v-if="frend" v-b-modal.modal-del-frend><b-icon-trash-fill></b-icon-trash-fill></b-button>
                <b-button v-if="frend" v-on:click="createOfferSDP('chat')">WebRTC1</b-button>
                <b-button v-if="frend" v-b-modal.modal-call><b-icon-telephone-fill></b-icon-telephone-fill></b-button>
                <b-button v-if="frend" v-b-modal.modal-video-call><b-icon-camera-reels-fill></b-icon-camera-reels-fill></b-button>
                </b-button-group>
            </b-navbar-nav>
        </b-navbar>

        <!-- Nav bar -->
        <b-navbar v-else sticky="true" class="w-100" type="light" variant="light">
            <b-navbar-nav>
                <b-button-group>
                <b-button v-on:click="app.frendList()"><b-icon-people-fill></b-icon-people-fill></b-button>
                <b-button v-b-modal.modal-add-frend><b-icon-person-plus-fill></b-icon-person-plus-fill></b-button>
                <b-button v-if="frend" v-b-modal.modal-edit-frend><b-icon-person-lines-fill></b-icon-person-lines-fill></b-button>
                <b-button v-if="frend" v-b-modal.modal-del-frend><b-icon-person-x-fill></b-icon-person-x-fill></b-button>
                <b-button v-if="frend" v-b-modal.modal-del-frend><b-icon-trash-fill></b-icon-trash-fill></b-button>
                <b-button v-if="frend" v-on:click="createOfferSDP('chat')">WebRTC1</b-button>
                <b-button v-if="frend" v-b-modal.modal-call><b-icon-telephone-fill></b-icon-telephone-fill></b-button>
                <b-button v-if="frend" v-b-modal.modal-video-call><b-icon-camera-reels-fill></b-icon-camera-reels-fill></b-button>
                </b-button-group>
            </b-navbar-nav>
        </b-navbar>

    <b-row v-if="isMobile" class="mb-2">
            <!-- Msg List -->
            <b-col cols="12">
            <div v-if="frend" class="mt-2 mb-2">
                <msg-list 
                    v-for="item in msgs" 
                    v-bind:msg="item"
                    v-bind:key="item.id">
                </msg-list>
            </div>       
            <!-- Start msg -->
            <div v-else>
                <frend-list
                    class="mt-2 mb-2"
                    v-for="item in frendsList" 
                    v-bind:frend="item"
                    v-bind:key="item.id">
                </frend-list>             
            </div>
            </b-col>
    </b-row>

    <b-row v-else class="mb-2">

        <!-- Frend List -->
        <b-col v-if="frendListVisible" cols="3">
            <frend-list 
                v-for="item in frendsList" 
                v-bind:frend="item"
                v-bind:key="item.id">
            </frend-list>
        </b-col>

        <div></div>

        <!-- Msg List -->
        <b-col cols="9">
        <div v-if="frend">
            <msg-list 
                v-for="item in msgs" 
                v-bind:msg="item"
                v-bind:key="item.id">
            </msg-list>
        </div>

        <!-- Start msg -->
        <div v-else>
            <div>
                <b-jumbotron bg-variant="light" text-variant="dark" border-variant="dark">
                  <template v-slot:header>Web-RTC messenger</template>
              
                  <template v-slot:lead>
                    This messenger work on Web-RTC technology.
                  </template>
              
                  <hr class="my-4">
              
                  <p>
                    <b-link href="https://webrtc.org/">More about Web-RTC</b-link>
                  </p>
                </b-jumbotron>
              </div>              
        </div>

        </b-col>

    </b-row>


    <!-- Msg form -->
    <div v-if="frend">

        <!-- Msg form for mobile -->
        <b-container v-if="isMobile">
            <b-row align-v="center mx-0" class="fixed-bottom m-0 rounded-0">
                <b-col cols="10">
                    <b-form-input
                        id="textarea"
                        v-bind:placeholder="frend.name"
                        v-model="sendMsgText"
                        rows="1"
                        max-rows="10"
                        class="w-100 xl"
                        ></b-form-input>
                </b-col>
                <b-col align-self="center" cols="2">
                    <b-button v-on:click="app.sendMsg()" class="w-100 xl"><b-icon-shift></b-icon-shift></b-button>
                </b-col>
            </b-row>
        </b-container>

        <!-- Msg form for desktop -->
        <b-container v-else>
            <b-row align-v="center mx-0" class="fixed-bottom m-0 rounded-0">
                <b-col cols="3"></b-col>
                <b-col cols="5">
                    <b-form-input
                        id="textarea"
                        v-bind:placeholder="frend.name"
                        v-model="sendMsgText"
                        rows="1"
                        max-rows="10"
                        class="w-100 xl"
                        ></b-form-input>
                </b-col>
                <b-col align-self="center" cols="1">
                    <b-button v-on:click="app.sendMsg()" class="w-100 xl"><b-icon-shift></b-icon-shift></b-button>
                </b-col>
                <b-col cols="3"></b-col>
            </b-row>
        </b-container>

    </div>

    </b-container>
    </div>

 

</body>

    <!-- JS -->
	<!-- api -->
    <script>let api_command = {
    "add_client":           "/client/add",
    "get_online_clients":   "/client/get",
    "del_client":           "/client/del",
    "send_message":         "/message/send",
    "get_messages":         "/message/get"
};

let my_sender_data = {
    "title": "Msg Alise",
    "name": "Alise",
    "private_key": "alice_private_rsa_key_pass.pem",
    "secret_code": "***",
    "key": "678"
}

let server_host = 'http://localhost:8080';
let public_key = '678';
let secret_key = '';

// обьявить серверу что клиент в сети
async function getOnline() {
    let url = server_host + api_command.add_client + "?key=" + public_key;
    let response = await sendRequest(url);
    let json = JSON.parse(response);
    if (json.message = "isOnline") {
        console.log('online');
        return true;
    } else {
        console.log('error');
        return false;
    }
}

// обьявить серверу что клиент вышел из сети
async function getOffline() {
    let url = server_host + api_command.del_client + "?key=" + public_key;
    let response = await sendRequest(url);
    let json = JSON.parse(response);
    if (json.message = "isOffline") {
        console.log('online');
    } else {
        console.log('error');
    }
}

// получить список друзей в сети
// keys - список открытых ключей друзей
async function getOnlineFrends(keys) {
    let url = server_host + api_command.get_online_clients + "?keys=" + keys;
    let response = await sendRequest(url);
    let json = JSON.parse(response);
    // TODO добавить обработку ошибки
    return json.online_users;
}

// отправить сообщение
async function sendMessage(message, sender, recipient) {
    let date = getFormatedDateTime();
    let sign = '111'; // TODO реализовать подпись RSA
    let url = server_host + api_command.send_message + "?content=" + message + "&sender=" + sender + "&recipient=" + recipient + "&date=" + date + "&sign=" + sign;
    let response = await sendRequest(url);
    let json = JSON.parse(response);
    console.log(json);
}

// получить сообщения
async function getMessages() {
    let url = server_host + api_command.get_messages + "?key=" + public_key;
    let response = await sendRequest(url);
    let json = JSON.parse(response);
    // console.log(json['messages-for-client']); // TODO заменить - на _ на сервере
    if (json['messages-for-client']) {
        return json['messages-for-client'];
    }
}

// отправка кросс-доменного запроса
async function sendRequest(url) {
    let response = await fetch(url, {
        headers: {
            origin: 'http://localhost:8080'
        }
      });
    let text = await response.text();
    return text;
}

function getFormatedDateTime() {
    let date = new Date();
    let curr_date = date.getDate() < 10 ? '0' + date.getDate() : date.getDate();
    let curr_month = (date.getMonth() + 1) < 10 ? '0' + (date.getMonth() + 1) : date.getMonth() + 1;
    let curr_year = date.getFullYear();
    let curr_hour = date.getHours();
    let curr_minute = date.getMinutes();
    let curr_secund = date.getSeconds();
    let space = '%20';
    let formated_date = curr_year + '-' + curr_month + '-' + curr_date + space + curr_hour + ':' + curr_minute + ':' + curr_secund; 

    return formated_date;
}
</script>
	<!-- webrtc -->
    <script>// offer/join
var server = { urls: "stun:stun.l.google.com:19302"};
var sdpConstraints = { optional: [{RtpDataChannels: true}]  };
var pc = new RTCPeerConnection(null);
var dc;
var state; //статус соединения
var sdp_msg; // SDP датаграмма

//---------media--------------

// type = 'video'/'audio'
async function mediaWebRTC(type){
  let constraints = {audio: true, video: true};
  if (type == 'audio') constraints = {audio: true, video: false};

  pc.ontrack = event => {
    const stream = event.streams[0];
    if (!remoteVideo.srcObject || remoteVideo.srcObject.id !== stream.id) {
      remoteVideo.srcObject = stream;
    }
  };

  navigator.mediaDevices.getUserMedia(constraints).then(stream => {
    // Display your local video in #localVideo element
    localVideo.srcObject = stream;
    // Add your stream to be sent to the conneting peer
    stream.getTracks().forEach(track => pc.addTrack(track, stream));
  });
}

//----------join--------------

// join 4
function dcInit(dc) {
  dc.onopen    = function()  {console.log("Conected!")};
  dc.onmessage = function(e) {if (e.data) console.log(e.data); app.addMsg(e.data, app.frend.name, 'I am');}
}

function joinWebRTC() {
    // join 1 
    pc.ondatachannel = function(e) {dc = e.channel; dcInit(dc)};
    // join 2 sdp датаграмма
    pc.onicecandidate = function(e) {
      if (e.candidate) return;
      sdp_msg = JSON.stringify(pc.localDescription);
      console.log(sdp_msg);
      sendMessage(sdp_msg, my_sender_data.key, app.frend.key);
    }
    // join 3 изменение статуса 
    pc.oniceconnectionstatechange = function(e) {
      state = pc.iceConnectionState;
      console.log(state);
    }
}

// join 5
// type = 'chat'/'video'/'audio'
async function createAnswerSDP(type, offerSDP) {
  if (type == 'video' || type == 'audio') await mediaWebRTC(type);
  joinWebRTC();
  var offerDesc = new RTCSessionDescription(offerSDP);
  pc.setRemoteDescription(offerDesc);
  pc.createAnswer(function (answerDesc) {
    pc.setLocalDescription(answerDesc)
  }, function () {console.warn("Couldn't create offer")},
  sdpConstraints);
}

//----------offer--------------

function offerWebRTC() {
  // offer 1 изменение статуса 
  pc.oniceconnectionstatechange = function(e) {
    state = pc.iceConnectionState;
    console.log(state);
  }
  // offer 2 sdp датаграмма
  pc.onicecandidate = function(e) {
    if (e.candidate) return;
    sdp_msg = JSON.stringify(pc.localDescription);
    console.log(sdp_msg);
    
    sendMessage(sdp_msg, my_sender_data.key, app.frend.key); // api
  }
}

// offer 3
// type = 'chat'/'video'/'audio'
async function createOfferSDP(type) {
  if (type == 'video' || type == 'audio') await mediaWebRTC(type);
  offerWebRTC();
  if (type == 'chat') dc = pc.createDataChannel("chat");
  pc.createOffer().then(function(e) {
    pc.setLocalDescription(e)
  });
  if (type == 'chat') {
    dc.onmessage = function(e) {
      if (e.data) console.log(e.data); app.addMsg(e.data, app.frend.name, 'I am'); //TODO добавление сообщения //addMSG(e.data, "other");
    }
  }
}

// offer 4
function start(answerSDP) {
  var answerDesc = new RTCSessionDescription(answerSDP);
  pc.setRemoteDescription(answerDesc);
}

//-----------------------------

// offer/join отправка сообщения
function sendMsgWebRtc (msg) {
  dc.send(msg);
}






</script>
	<!-- DB -->
    <script>// Функции работы с БД

async function addFrendToDb(db, frend) {
  return new Promise((resolve, reject) => {
    let trans = db.transaction(['frends'],'readwrite');
    trans.oncomplete = e => {
      resolve();
    };
    let store = trans.objectStore('frends');
    //store.add(frend);
    store.put(frend);
  });
}

async function addMsgToDb(db, msg) {
  return new Promise((resolve, reject) => {
    let trans = db.transaction(['msgs'],'readwrite');
    trans.oncomplete = e => {
      resolve();
    };
    let store = trans.objectStore('msgs');
    store.add(msg);
  });
}

async function deleteFrendFromDb(db, id) {
  return new Promise((resolve, reject) => {
    let trans = db.transaction(['frends'],'readwrite');
    trans.oncomplete = e => {
      resolve();
    };
    let store = trans.objectStore('frends');
    store.delete(id);
  });
}

async function deleteMsgFromDb(db, id) {
  return new Promise((resolve, reject) => {
    let trans = db.transaction(['msgs'],'readwrite');
    trans.oncomplete = e => {
      resolve();
    };
    let store = trans.objectStore('msgs');
    store.delete(id);
  });
}

async function getFrendsFromDb(db) {
  return new Promise((resolve, reject) => {
    let trans = db.transaction(['frends'],'readonly');
    trans.oncomplete = e => {
      resolve(frends);
    };
    let store = trans.objectStore('frends');
    let frends = [];
    store.openCursor().onsuccess = e => {
      let cursor = e.target.result;
      if (cursor) {
        frends.push(cursor.value)
        cursor.continue();
      }
    };
  });
}

async function getMsgsFromDb(db, frend) {
  return new Promise((resolve, reject) => {
  let trans = db.transaction(['msgs'],'readonly');
    trans.oncomplete = e => {
      resolve(msgs);
    };
    let store = trans.objectStore('msgs');
    let msgs = [];
    store.openCursor().onsuccess = e => {
      let cursor = e.target.result;
      if (cursor) {
        if (cursor.value.from == frend || cursor.value.to == frend) {
          if (cursor.value.from != MY_NAME) {
            cursor.value.class = "text-left"
          } else {
            cursor.value.class = "text-right"
          }
          msgs.push(cursor.value)
          cursor.continue();
        } else {
          cursor.continue();
        }
      }
    };
  });
}

async function getDb() {
  return new Promise((resolve, reject) => {
    let request = window.indexedDB.open(DB_NAME, DB_VERSION);      
    request.onerror = e => {
      console.log('Error opening db', e);
      reject('Error');
    };
    request.onsuccess = e => {
      resolve(e.target.result);
    };      
    request.onupgradeneeded = e => {
      console.log('onupgradeneeded');
      let db = e.target.result;
      let objectStoreFrends = db.createObjectStore("frends", { autoIncrement: true, keyPath:'id' });
      let objectStoreMsgs = db.createObjectStore("msgs", { autoIncrement: true, keyPath:'id' });
    };
  });
}

</script>
	<!-- main -->
    <script>

const DB_NAME = 'msgdb';
const DB_VERSION = 1;

const MY_NAME = 'I am';

Vue.component('frend-list', {
    props: ['frend'],
    template: '<b-button v-on:click="app.getMsgsFrom(frend)" block>{{ frend.name }}</b-button>'
})

Vue.component('frend-list-dropdown', {
  props: ['frend'],
  template: '<b-dropdown-item v-on:click="app.getMsgsFrom(frend)">{{ frend.name }}<b-dropdown-item>'
})

Vue.component('msg-list', {
    props: ['msg'],
    template: `
      <b-card class="mb-2" :class="msg.class">
        <b-card-text class="mb-0 small text-muted">{{ msg.from }}</b-card-text>
        <b-card-text class="mb-0">{{ msg.text }}</b-card-text>
        <b-card-text class="mb-0 small text-muted"><em>{{ msg.datetime }}</em></b-card-text>
      </b-card>`
})

var app = new Vue({
    el: '#app',
    data: {
      message: 'WEB-RTC msg in Vue!',
      frendsList: [],
      msgs: [],
      sendMsgText: '',
      db:null,
      webrtc: [false, ''],

      showDismissibleAlert: true,

      // frend name
      name:'',
      nameState: null,

      // frend public RSA key
      key:'',
      keyState: null,

      ready:false,
      addDisabled:false,
      frend:false,
      frendId:false,
      frendListVisible: true,
      widthMsgList: 9,
      isMobile:false,
      updateInterval:5000 // частота обновления сообщений 5 сек
    },
    async created() {
        this.db = await getDb();
        this.frendsList = await getFrendsFromDb(this.db);
        this.ready = true;
        //this.isMobile = false;
        this.brouser = false;
        this.detectDevice();

        if (getOnline()) await this.updateMsgs(); // обновление сообщений // getOnline - api
    },
    methods: {

      frendList() {
        this.frendListVisible = !this.frendListVisible;
        this.widthMsgList = this.frendListVisible ? 9 : 12;
      },

      detectDevice() {
        let detect = new MobileDetect(window.navigator.userAgent);
        if (detect.phone()) {
          this.isMobile = true;
        }
        // console.log("Mobile: " + detect.mobile());       // телефон или планшет 
        // console.log("Phone: " + detect.phone());         // телефон 
        // console.log("Tablet: " + detect.tablet());       // планшет 
        // console.log("OS: " + detect.os());               // операционная система 
        // console.log("userAgent: " + detect.userAgent()); // userAgent
      },

      // -------------- Add frends metods ----------------------

      checkFormValidity() {
        const valid = this.$refs.form.checkValidity()
        this.nameState = valid
        return valid
      },

      resetModal() {
        this.name = ''
        this.nameState = null
      },

      handleOk(bvModalEvt) {
        bvModalEvt.preventDefault()
        this.handleSubmit()
      },

      handleSubmit() {
        if (!this.checkFormValidity()) {
          return
        }
        this.addFrend(this.name, this.key);
        this.$nextTick(() => {
          this.$bvModal.hide('modal-add-frend')
        })
      },

      // -------------- del frend ------------

      handleDel() {
        this.deleteFrend(this.frend.id);
        this.frend = false;
      },

      // --------------- edit frend -------------------

      handleEdit() {
        this.editFrend(this.frend);
      },

      // --------------- del all msg -------------------

      handleDelAllMsg() {
        
      },

      // --------------- Metods ------------------------

      updateMsgs: async function () {
          let msgs = await getMessages(); // api
          // console.log('123');
          if (msgs.length > 0) {
            msgs = JSON.parse(msgs[0]['content'])
            console.log(msgs);
            if (msgs['type'] == 'offer') createAnswerSDP('chat', msgs);
            if (msgs['type'] == 'answer') start(msgs);
          }
          setTimeout(this.updateMsgs, this.updateInterval);
        },

        sendMsg: async function () {
          this.addMsg(this.sendMsgText, 'I am', this.frend.name);
          // WebRTC
          sendMsgWebRtc(this.sendMsgText);
          this.sendMsgText = '';
          this.msgs = await getMsgsFromDb(this.db, this.frend.name);
        },

        getFrend: async function() {
          this.getFrendFromDb(this.frend.id);
        },

        back: function() {
          this.frend = false;
          sayHi();
        },

        getMsgsFrom: async function (frend) {            
            this.frend = frend;
            this.msgs = await getMsgsFromDb(this.db, this.frend.name);
        },

        // ------------------- Работа с БД -------------------------

          async addFrend(name, key) {
            this.addDisabled = true;
            let frend = {
              name: name,
              key: key
            };
            console.log('Add frend to DB: '+JSON.stringify(frend));
            await addFrendToDb(this.db, frend);
            this.frendsList = await getFrendsFromDb(this.db);
            this.addDisabled = false;      
          },

          async editFrend(frend) {
            this.addDisabled = true;
            await addFrendToDb(this.db, frend);
            this.frendsList = await getFrendsFromDb(this.db);
            this.addDisabled = false;
          },

          async deleteFrend(id) {
            await deleteFrendFromDb(this.db, id);
            this.frendsList = await getFrendsFromDb(this.db);      
          },

          async addMsg(text, from, to) {
            this.addDisabled = true;
            let nowStr = new Date().toLocaleString();
            let msg = {
              datetime: nowStr,
              text: text,
              from: from,
              to: to
            };
            console.log('Add msg to DB: '+JSON.stringify(msg));
            await addMsgToDb(this.db, msg);
            this.msgs = await getMsgsFromDb(this.db, this.frend.name);
            this.addDisabled = false;      
          },

          async deleteMsg(id) {
            await deleteMsgFromDb(this.db, id);
            this.msgs = await getMsgsFromDb(this.db, this.frend.name);      
          },
    }
})

</script>

</html>






<!-- <!DOCTYPE html>
<html lang="ru-RU">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<title>Web-приложение</title>
	</head>
	<body>
		<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">  
			<a class="navbar-brand" href="index.php">Web-app</a>
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="navbar-nav">
					<li class="nav-item">
						<a class="nav-link" href="index.php?r=site/create-category">Создать категорию</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="index.php?r=site/create-good">Создать товар</a>
					</li>	
				</ul>
			</div>
		</nav>

		<div class="container mt-4">
			<?= $content ?>
		</div>
	
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	</body>
</html> -->
