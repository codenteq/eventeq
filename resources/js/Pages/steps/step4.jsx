import {Input, Label} from "@codenteq/interfeys";
import React, {useEffect} from "react";

export default function Step4({data, setData}) {

    useEffect(() => {
        console.log(data);
    }, [data]);

    return (
        <>
            <div className="my-5">
                <h3>Adım 4: Ekipman Bilgileri</h3>
                <p>(Alana getireceğiniz ekipmanlardan bahsetmek isterseniz aşağıda belirtiniz. İstatistik amaçlıdır.)</p>
            </div>
            <div className="grid gap-5 mb-6 lg:grid-cols-1">
                <div className="flex items-center mb-4">
                    <Input
                        id="bring_telescope"
                        name="bring_telescope"
                        type="checkbox"
                        checked={data.bring_telescope || false}
                        onChange={(e) => setData('bring_telescope', e.target.checked)}
                        className="mr-2"
                    />
                    <Label htmlFor="bring_telescope">
                        Yanınızda teleskop getirecek misiniz?
                    </Label>
                </div>

                <div className="flex items-center mb-6">
                    <Input
                        id="share_telescope"
                        name="share_telescope"
                        type="checkbox"
                        checked={data.share_telescope || false}
                        onChange={(e) => setData('share_telescope', e.target.checked)}
                        className="mr-2"
                    />
                    <Label htmlFor="share_telescope">
                        Yanınızda getireceğiniz teleskopla diğer katılımcılara gözlem yaptiracak mısınız?
                    </Label>
                </div>
                {/*<Input
                    name="telescope"
                    value={data.telescope}
                    onChange={(e) => setData('telescope', e.target.value)}
                    min={0}
                    type="number"
                    label="Teleskop"
                    helpText="Kaç adet teleskop getireceksiniz?"
                    className="block w-full"
                />
                <Input
                    name="telescope_brand"
                    value={data.telescope_brand}
                    onChange={(e) => setData('telescope_brand', e.target.value)}
                    type="text"
                    label="Teleskop markası"
                    className="block w-full"
                />
                <Input
                    name="swaddling"
                    value={data.swaddling}
                    onChange={(e) => setData('swaddling', e.target.value)}
                    type="number"
                    min={0}
                    label="Kundak"
                    helpText="Kaç adet kundak getireceksiniz?"
                    className="block w-full"
                />
                <Input
                    name="swaddling_brand"
                    type="text"
                    label="Kundak markası"
                    className="block w-full"
                />
                <Input
                    name="binocular"
                    value={data.binocular}
                    onChange={(e) => setData('binocular', e.target.value)}
                    type="number"
                    min={0}
                    label="Dürbün"
                    helpText="Kaç adet dürbün getireceksiniz?"
                    className="block w-full"
                />
                <Input
                    name="camera"
                    value={data.camera}
                    onChange={(e) => setData('camera', e.target.value)}
                    type="number"
                    min={0}
                    label="Fotoğraf makinesi"
                    helpText="Kaç adet fotoğraf makinesi getireceksiniz?"
                    className="block w-full"
                />
                <Input
                    name="tripod"
                    value={data.tripod}
                    onChange={(e) => setData('tripod', e.target.value)}
                    type="number"
                    min={0}
                    label="Tripod"
                    helpText="Kaç adet tripod getireceksiniz?"
                    className="block w-full"
                />
                <Input
                    name="walkie_talkie"
                    value={data.walkie_talkie}
                    onChange={(e) => setData('walkie_talkie', e.target.value)}
                    type="number"
                    min={0}
                    label="Telsiz"
                    helpText="Kaç adet telsiz getireceksiniz?"
                    className="block w-full"
                />
                <Input
                    name="computer"
                    value={data.computer}
                    onChange={(e) => setData('computer', e.target.value)}
                    type="number"
                    min={0}
                    label="Bilgisayar"
                    helpText="Kaç adet bilgisayar getireceksiniz?"
                    className="block w-full"
                />*/}
            </div>
        </>
    )
}
