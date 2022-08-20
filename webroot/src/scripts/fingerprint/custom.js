/**
 * Custom implementation for the FingerPrint
 * Reader and other JS functions
 * @authors Dahir Muhammad Dahir (dahirmuhammad3@gmail.com)
 * @date    2020-04-14 17:06:41
 * @version 1.0.0
 */


let currentFormat = Fingerprint.SampleFormat.Intermediate;

let FingerprintSdkTest = (function () {
    function FingerprintSdkTest() {
        let _instance = this;
        this.operationToRestart = null;
        this.acquisitionStarted = false;
        // instantiating the fingerprint sdk here
        this.sdk = new Fingerprint.WebApi;
        this.sdk.onDeviceConnected = function (e) {
            // Detects if the device is connected for which acquisition started
            showMessage("Escanear el dedo apropiado en el lector", "info");
        };
        this.sdk.onDeviceDisconnected = function (e) {
            // Detects if device gets disconnected - provides deviceUid of disconnected device
            showMessage("El dispositivo está desconectado. Por favor, vuelva a conectarse", "error");
        };
        this.sdk.onCommunicationFailed = function (e) {
            // Detects if there is a failure in communicating with U.R.U web SDK
            showMessage("Comunicación fallida. Vuelva a conectar el dispositivo", "error")
        };
        this.sdk.onSamplesAcquired = function (s) {
            // Sample acquired event triggers this function
            storeSample(s);
        };
        this.sdk.onQualityReported = function (e) {
            // Quality of sample acquired - Function triggered on every sample acquired
            //document.getElementById("qualityInputBox").value = Fingerprint.QualityCode[(e.quality)];
        }
    }

    // this is were finger print capture takes place
    FingerprintSdkTest.prototype.startCapture = function () {
        if (this.acquisitionStarted) // Monitoring if already started capturing
            return;
        let _instance = this;
        showMessage("Capturando huella", 'info');
        this.operationToRestart = this.startCapture;
        this.sdk.startAcquisition(currentFormat, "").then(function () {
            _instance.acquisitionStarted = true;

            //Disabling start once started
            //disableEnableStartStop();

        }, function (error) {
            showMessage(error.message);
        });
    };

    FingerprintSdkTest.prototype.stopCapture = function () {
        if (!this.acquisitionStarted) //Monitor if already stopped capturing
            return;
        let _instance = this;
        this.sdk.stopAcquisition().then(function () {
            _instance.acquisitionStarted = false;
            //Disabling stop once stopped
            //disableEnableStartStop();

        }, function (error) {
            showMessage(error.message);
        });
    };

    FingerprintSdkTest.prototype.getInfo = function () {
        let _instance = this;
        return this.sdk.enumerateDevices();
    };

    FingerprintSdkTest.prototype.getDeviceInfoWithID = function (uid) {
        let _instance = this;
        return this.sdk.getDeviceInfo(uid);
    };

    return FingerprintSdkTest;
})();


class Reader {
    constructor() {
        this.reader = new FingerprintSdkTest();
        this.selectFieldID = null;
        this.currentStatusField = null;
        /**
         * @type {Hand}
         */
        this.currentHand = null;
    }

    readerSelectField(selectFieldID) {
        this.selectFieldID = selectFieldID;
    }

    setStatusField(statusFieldID) {
        this.currentStatusField = statusFieldID;
    }

    displayReader() {
        let readers = this.reader.getInfo();  // grab available readers here
        let id = this.selectFieldID;
        let selectField = document.getElementById(id);
        selectField.innerHTML = `<option>Seleccionar lector de huellas dactilares</option>`;
        readers.then(function (availableReaders) {  // when promise is fulfilled
            if (availableReaders.length > 0) {
                showMessage("Lector de Huellas conectado con exito", "success");
                for (let reader of availableReaders) {
                    selectField.innerHTML += `<option value="${reader}" selected>${reader}</option>`;
                }
            }
            else {
                showMessage("Conecte el lector de huellas dactilares");
            }
        })
    }
}

class Hand {
    constructor() {
        this.id = 0;
        this.index_finger = [];
        this.middle_finger = [];
    }

    addIndexFingerSample(sample) {
        this.index_finger.push(sample);
    }

    addMiddleFingerSample(sample) {
        this.middle_finger.push(sample);
    }

    generateFullHand() {
        let id = this.id;
        let index_finger = this.index_finger;
        let middle_finger = this.middle_finger;
        let training_id = 0;
        return JSON.stringify({ id, index_finger, middle_finger, training_id });
    }
}

let myReader = new Reader();

function beginEnrollment() {
    setReaderSelectField("enrollReaderSelect");
    myReader.setStatusField("enrollmentStatusField");
}

function beginIdentification() {
    setReaderSelectField("verifyReaderSelect");
    myReader.setStatusField("verifyIdentityStatusField");
}

function setReaderSelectField(fieldName) {
    myReader.readerSelectField(fieldName);
    myReader.displayReader();
}

function showMessage(message, message_type = "error") {
    let types = new Map();
    types.set("success", "my-text7 my-pri-color text-bold");
    types.set("error", "text-danger");
    let statusFieldID = myReader.currentStatusField;
    if (statusFieldID) {
        let statusField = document.getElementById(statusFieldID);
        statusField.innerHTML = `<p class="my-text7 my-pri-color my-3 ${types.get(message_type)} font-weight-bold">${message}</p>`;
    }

    if (message_type === 'success') {
        iziToast.success({
            // title: 'Hey',
            position: 'topCenter',
            message: message
        });
    }

    if (message_type === 'error') {
        iziToast.error({
            // title: 'Hey',
            position: 'topCenter',
            message: message
        });
    }

    if (message_type === 'warning') {
        iziToast.warning({
            // title: 'Hey',
            position: 'topCenter',
            message: message
        });
    }


}

function beginCapture(user_id) {
    document.getElementById("userID").value = user_id;
    document.getElementById("userIDVerify").value = "";

    if (!readyForEnroll()) {
        return;
    }
    myReader.currentHand = new Hand();
    storeUserID();  // for current user in Hand instance
    myReader.reader.startCapture();
    showNextNotEnrolledItem();
}

function captureForIdentify(user_id) {
    document.getElementById("userID").value = "";
    document.getElementById("userIDVerify").value = document.getElementById("userIDVerifyTMP").value;
    if (!readyForIdentify()) {
        return;
    }
    myReader.currentHand = new Hand();
    storeUserID();
    myReader.reader.startCapture();
    showNextNotEnrolledItem();
}

/**
 * @returns {boolean}
 */
function readyForEnroll() {
    return ((document.getElementById("userID").value !== "") && (document.getElementById("enrollReaderSelect").value !== "Seleccionar lector de huellas dactilares"));
}

/**
* @returns {boolean}
*/
function readyForIdentify() {
    return ((document.getElementById("userIDVerify").value !== "") && (document.getElementById("verifyReaderSelect").value !== "Seleccionar lector de huellas dactilares"));
}

function clearCapture() {
    clearInputs();
    clearPrints();
    clearHand();
    myReader.reader.stopCapture();
}

function clearInputs() {
    document.getElementById("userID").value = "";
    document.getElementById("userIDVerify").value = "";
    //let id = myReader.selectFieldID;
    //let selectField = document.getElementById(id);
    //selectField.innerHTML = `<option>Seleccionar lector de huellas dactilares</option>`;
}

function clearPrints() {
    let indexFingers = document.getElementById("indexFingers");
    let middleFingers = document.getElementById("middleFingers");
    let verifyFingers = document.getElementById("verificationFingers");

    if (indexFingers) {
        for (let indexfingerElement of indexFingers.children) {
            indexfingerElement.innerHTML = `<span class="icon icon-indexfinger-not-enrolled" title="not_enrolled"></span>`;
        }
    }

    if (middleFingers) {
        for (let middlefingerElement of middleFingers.children) {
            middlefingerElement.innerHTML = `<span class="icon icon-middlefinger-not-enrolled" title="not_enrolled"></span>`;
        }
    }

    if (verifyFingers) {
        for (let finger of verifyFingers.children) {
            finger.innerHTML = `<span class="icon icon-indexfinger-not-enrolled" title="not_enrolled"></span>`;
        }
    }
}

function clearHand() {
    myReader.currentHand = null;
}

function showSampleCaptured() {
    let nextElementID = getNextNotEnrolledID();
    let markup = null;
    if (nextElementID.startsWith("index") || nextElementID.startsWith("verification")) {
        markup = `<span class="icon icon-indexfinger-enrolled" title="enrolled"></span>`;
    }

    if (nextElementID.startsWith("middle")) {
        markup = `<span class="icon icon-middlefinger-enrolled" title="enrolled"></span>`;
    }

    if (nextElementID !== "" && markup) {
        let nextElement = document.getElementById(nextElementID);
        nextElement.innerHTML = markup;
    }
}

function showNextNotEnrolledItem() {
    let nextElementID = getNextNotEnrolledID();
    let markup = null;
    if (nextElementID.startsWith("index") || nextElementID.startsWith("verification")) {
        markup = `<span class="icon capture-indexfinger" title="not_enrolled"></span>`;
    }

    if (nextElementID.startsWith("middle")) {
        markup = `<span class="icon capture-middlefinger" title="not_enrolled"></span>`;
    }

    if (nextElementID !== "" && markup) {
        let nextElement = document.getElementById(nextElementID);
        nextElement.innerHTML = markup;
    }
}

/**
 * @returns {string}
 */
function getNextNotEnrolledID() {
    let indexFingers = document.getElementById("indexFingers");
    let middleFingers = document.getElementById("middleFingers");
    let verifyFingers = document.getElementById("verificationFingers");

    let enrollUserId = document.getElementById("userID").value;
    let verifyUserId = document.getElementById("userIDVerify").value;

    let indexFingerElement = findElementNotEnrolled(indexFingers);
    let middleFingerElement = findElementNotEnrolled(middleFingers);
    let verifyFingerElement = findElementNotEnrolled(verifyFingers);

    //assumption is that we will always start with
    //indexfinger and run down to middlefinger
    if (indexFingerElement !== null && enrollUserId !== "") {
        return indexFingerElement.id;
    }

    if (middleFingerElement !== null && enrollUserId !== "") {
        return middleFingerElement.id;
    }

    if (verifyFingerElement !== null && verifyUserId !== "") {
        return verifyFingerElement.id;
    }

    return "";
}

/**
 * 
 * @param {Element} element
 * @returns {Element}
 */
function findElementNotEnrolled(element) {
    if (element) {
        for (let fingerElement of element.children) {
            if (fingerElement.firstElementChild.title === "not_enrolled") {
                return fingerElement;
            }
        }
    }

    return null;
}

function storeUserID() {
    let enrollUserId = document.getElementById("userID").value;
    let identifyUserId = document.getElementById("userIDVerify").value;
    myReader.currentHand.id = enrollUserId !== "" ? enrollUserId : identifyUserId;
}

function storeSample(sample) {
    let samples = JSON.parse(sample.samples);
    let sampleData = samples[0].Data;

    let nextElementID = getNextNotEnrolledID();

    if (nextElementID.startsWith("index") || nextElementID.startsWith("verification")) {
        myReader.currentHand.addIndexFingerSample(sampleData);
        showSampleCaptured();
        showNextNotEnrolledItem();
        return;
    }

    if (nextElementID.startsWith("middle")) {
        myReader.currentHand.addMiddleFingerSample(sampleData);
        showSampleCaptured();
        showNextNotEnrolledItem();
    }
}

function serverEnroll() {
    if (!readyForEnroll()) {
        return;
    }

    let data = myReader.currentHand.generateFullHand();
    let successMessage = "¡Inscripción exitosa!";
    let failedMessage = "¡Error en la inscripción!";
    let payload = `data=${data}`;

    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            if (this.responseText === "success") {
                showMessage(successMessage, "success");
            }
            else {
                showMessage(`${failedMessage} ${this.responseText}`);
            }
        }
    };

    xhttp.open("POST", "/api/enroll", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(payload);
}

function serverIdentify() {
    if (!readyForIdentify()) {
        return;
    }

    let data = myReader.currentHand.generateFullHand();
    let successMessage = "¡Identificación exitosa!";
    let failedMessage = "Identificación fallida!. Intentar otra vez";
    let payload = `data=${data}`;

    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            if (this.responseText !== null && this.responseText !== "") {
                let response = this.responseText;
                if (response !== "failed" && response !== null) {
                    showMessage(successMessage, "success");
                }
                else {
                    showMessage(failedMessage);
                }
            }
        }
    };

    xhttp.open("POST", "/api/verify", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(payload);
}


function serverIdentifyAssistance() {
    if (!readyForIdentify()) {
        return;
    }

    let data = JSON.parse(myReader.currentHand.generateFullHand());
    data.training_id = document.getElementById('TrainingID').value;

    data = JSON.stringify(data);
    let successMessage = "¡Identificación exitosa!";
    let failedMessage = "Identificación fallida!. Intentar otra vez";
    let payload = `data=${data}`;

    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            if (this.responseText !== null && this.responseText !== "") {
                let response = this.responseText;
                if (response !== "failed" && response !== null) {
                    showMessage(successMessage, "success");
                    if ($("#TrainingID")) clearCapture();
                    location.reload()

                    $('#modal-1').modal('hide');
                }
                else {
                    showMessage(failedMessage);

                }
            }
        }
    };

    xhttp.open("POST", "/api/verify", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(payload);
}
