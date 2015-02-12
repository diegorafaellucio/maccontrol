/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function showCompare(url) {
    winCompare = new Window({className: 'magento', title: 'Compare Products', url: url, width: 820, height: 600, minimizable: false, maximizable: false, showEffectOptions: {duration: 0.4}, hideEffectOptions: {duration: 0.4}});
    winCompare.setZIndex(100);
    winCompare.showCenter(true);
}
