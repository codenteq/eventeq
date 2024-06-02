import {Button, Input} from "@codenteq/interfeys";
import React from "react";

export default function Step5({ onPrev, onFinish }) {
    const handlePrevClick = () => {
        console.log('Önceki butona tıklandı!');
        onPrev();
    };

    const handleFinishClick = () => {
        console.log('Tamamla butona tıklandı!');
        onFinish();
    };
    return (
        <>
            <div className="grid gap-5 mb-6 lg:grid-cols-2">
                <Input
                    name="arrival_date"
                    type="date"
                    label="Varış tarihi"
                    className="block w-full"
                />
                <Input
                    name="departure_date"
                    type="date"
                    label="Ayrılış tarihi"
                    className="block w-full"
                />
            </div>
            <div className="flex items-center justify-between">
                <button type="button" onClick={handlePrevClick} className="mr-2">
                    Önceki
                </button>
                <Button type="submit" label="Tamamla" onClick={handleFinishClick}/>
            </div>
        </>
    )
}
