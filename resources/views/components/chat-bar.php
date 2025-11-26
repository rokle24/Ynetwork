<link rel="stylesheet" href="{{ asset('css/ChatBarStyle.css') }}">

<style>
    #rightBar {
        position: fixed;
        bottom: 60px;
        right: 0;
        width: 340px;
        height: auto;
        max-height: calc(90vh - 60px);
        background: white;
        box-shadow: -10px 0 20px rgba(0,0,0,0.3);
        transform: translateX(100%);
        transition: transform 0.35s ease;
        z-index: 99999;
        display: flex;
        flex-direction: column;
        border-left: 2px solid #000;
        border-top: 2px solid #000;
        pointer-events: auto;
    }
    #rightBar.open {
        transform: translateX(0);
    }
    #chatButton.move {
        margin-right: 350px;
        transition: margin-right 0.35s ease;
    }
    #chatInput, #msgInput, #sendBtn {
        pointer-events: auto !important;
    }
</style>

<div class="w3-bar w3-light-blue w3-border-bottom w3-border-black"
     style="position:fixed;bottom:0;width:100%;z-index:99998;height:60px">
    <div class="w3-bar-item w3-right">
        <button id="chatButton"
                class="w3-button w3-black w3-round-xxlarge"
                style="padding:12px 32px;margin-right:10px;margin-bottom:8px">
            Chat
        </button>
    </div>
</div>

<div id="rightBar">
    <div class="w3-light-blue w3-padding-large w3-border-bottom w3-border-black">
        <h4 class="w3-margin-0">Messages</h4>
    </div>

    <div id="chatContent"
         style="flex:1;overflow-y:auto;display:flex;flex-direction:column;
                min-height:380px;max-height:78vh;background:#f8f8f8">
    </div>

    <div id="chatInput"
         class="w3-padding w3-border-top w3-light-grey"
         style="display:none;background:white">
        <div class="w3-row">
            <div class="w3-col s9 m9 l9">
                <input id="msgInput"
                       class="w3-input w3-border w3-round-xlarge"
                       style="background:#f2f2f2;height:46px"
                       placeholder="Type a message..."
                       autocomplete="off">
            </div>
            <div class="w3-col s3 m3 l3">
                <button id="sendBtn"
                        class="w3-button w3-black w3-round-xlarge w3-block"
                        style="height:46px">
                    Send
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {

        const btn       = document.getElementById("chatButton");
        const bar       = document.getElementById("rightBar");
        const content   = document.getElementById("chatContent");
        const inputArea = document.getElementById("chatInput");
        const msgInput  = document.getElementById("msgInput");
        const sendBtn   = document.getElementById("sendBtn");

        let currentUserId = null;

        btn.onclick = () => {
            bar.classList.toggle("open");
            if (bar.classList.contains("open")) {
                btn.classList.add("move");
                if (content.children.length === 0) loadUserList();
            } else {
                btn.classList.remove("move");
            }
        };

        const loadUserList = async () => {
            content.innerHTML = "<p class='w3-center w3-text-grey'>Loading...</p>";
            inputArea.style.display = "none";

            try {
                const res   = await fetch("/api/friends/list");
                const users = await res.json();

                content.innerHTML = "";

                users.forEach(u => {
                    const name = u.full_name || u.name || u.username || "User";
                    const b = document.createElement("button");
                    b.textContent = name;
                    b.className =
                        "w3-button w3-block w3-border w3-round-xlarge " +
                        "w3-margin-bottom w3-hover-light-grey";
                    b.style.padding = "16px";
                    b.onclick = () => openChat(u.id, name);
                    content.appendChild(b);
                });

            } catch (err) {
                content.innerHTML =
                    "<p class='w3-text-red'>Can't load users</p>";
            }
        };

        const openChat = async (userId, userName) => {

            currentUserId = userId;
            inputArea.style.display = "block";

            content.innerHTML = `
            <div class="w3-bar w3-light-blue w3-border-bottom w3-border-black">
                <button id="backBtn" class="w3-button">
                    <i class="fa fa-arrow-left"></i>
                </button>
                <span class="w3-bar-item w3-large">${userName}</span>
            </div>
            <div id="msgHistory"
                 style="flex:1;overflow-y:auto;padding:10px;background:#f8f8f8">
            </div>
        `;

            document.getElementById("backBtn").onclick = loadUserList;

            const history = document.getElementById("msgHistory");

            try {
                const res  = await fetch(`/api/chat/history?user=${userId}`);
                const data = await res.json();

                history.innerHTML = "";

                (data.data || []).forEach(m => {
                    addMessage(m.message, m.user_from != userId);
                });

                scrollToBottom();

            } catch (e) {
                console.error(e);
            }

            const send = async () => {
                const text = msgInput.value.trim();
                if (!text) return;

                addMessage(text, true);
                msgInput.value = "";
                scrollToBottom();

                try {
                    await fetch("/messages/send", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN":
                                document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute("content")
                        },
                        body: JSON.stringify({
                            user_to: userId,
                            message: text
                        })
                    });
                } catch (e) {
                    console.error("Send failed", e);
                }
            };

            sendBtn.onclick = send;

            msgInput.onkeydown = e => {
                if (e.key === "Enter") {
                    e.preventDefault();
                    send();
                }
            };

            setTimeout(() => msgInput.focus(), 150);
        };

        const addMessage = (text, isMine) => {
            const div = document.createElement("div");
            div.textContent = text;
            div.className =
                `w3-padding w3-round-xlarge w3-margin-bottom ${
                    isMine
                        ? "w3-black w3-text-white w3-right"
                        : "w3-light-grey"
                }`;
            div.style.maxWidth = "80%";
            div.style.clear = "both";

            document.getElementById("msgHistory").appendChild(div);
        };

        const scrollToBottom = () => {
            const h = document.getElementById("msgHistory");
            if (h) h.scrollTop = h.scrollHeight;
        };

    });
</script>
