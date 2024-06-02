import {Button, Input} from "@codenteq/interfeys";
import React from "react";

export default function Step4({ onNext, onPrev }) {
    const handlePrevClick = () => {
        console.log('Önceki butona tıklandı!');
        onPrev();
    };

    const handleNextClick = () => {
        console.log('Sonraki butona tıklandı!');
        onNext();
    };
    return (
        <>
            <div className="grid gap-5 mb-6 lg:grid-cols-2">
                <Input
                    name="telescope"
                    type="number"
                    value="0"
                    label="Teleskop"
                    helpText="Kaç adet teleskop getirebilirsiniz?"
                    className="block w-full"
                />
                <Input
                    name="telescope_brand"
                    type="text"
                    label="Teleskop markası"
                    className="block w-full"
                />
                <Input
                    name="swaddling"
                    type="number"
                    value="0"
                    label="Kundak"
                    helpText="Kaç adet kundak getirebilirsiniz?"
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
                    type="number"
                    value="0"
                    label="Dürbün"
                    helpText="Kaç adet dürbün getirebilirsiniz?"
                    className="block w-full"
                />
                <Input
                    name="camera"
                    type="number"
                    value="0"
                    label="Fotoğraf makinesi"
                    helpText="Kaç adet fotoğraf makinesi getirebilirsiniz?"
                    className="block w-full"
                />
                <Input
                    name="tripod"
                    type="number"
                    value="0"
                    label="Tripod"
                    helpText="Kaç adet tripod getirebilirsiniz?"
                    className="block w-full"
                />
                <Input
                    name="walkie_talkie"
                    type="number"
                    value="0"
                    label="Telsiz"
                    helpText="Kaç adet telsiz getirebilirsiniz?"
                    className="block w-full"
                />
                <Input
                    name="computer"
                    type="number"
                    value="0"
                    label="Bilgisayar"
                    helpText="Kaç adet bilgisayar getirebilirsiniz?"
                    className="block w-full"
                />
            </div>
            <div className="flex items-center justify-between">
                <button type="button" onClick={handlePrevClick} className="mr-2">
                    Önceki
                </button>
                <Button type="submit" label="Sonraki" onClick={handleNextClick}/>
            </div>
        </>
    )
}
