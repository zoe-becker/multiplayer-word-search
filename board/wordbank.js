/**TODO
 * SCRUM-57
 * Display words on wordbank that aren't hardcoded
 * 
 *  When document is loaded do:
 *      Fetch data from test json
 *      
 *      When data is fetched successfully:
 *          parse the fetched data into json format
 * 
 *             when json parsing is successful:
 *                  get the html element with ID "wordBankList" and store it as wordBankList
 *                  
 *                  For each word in the "words" list:
 *                          create a new list item
 *                           set the content of the list item to the current word.
 *                           append the list item to the wordBankList element
 * 
 * 
 * Add error handling later
 */

// checks when page is loaded
document.addEventListener('DOMContentLoaded', function(event) {
    //When data is fetched successfully:
    // parse the fetched data into json format
    fetch('puzzle.json')
        .then(response => response.json())
        .then(data=>{
            // get the html element with ID "wordBankList" and store it as wordBankList
            const wordBankList = document.getElementById("wordBankList");

            data.words.forEach(word => {
                let listItem = document.createElement("li"); //  create a new list item
                listItem.textContent = word;                // set contnet of the list item to the current word
                wordBankList.appendChild(listItem);         //  append the list item to the word banklist element
            })
        })
})