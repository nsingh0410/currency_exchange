import React, { useEffect, useState } from 'react';
import axios from 'axios';
import {
  LineChart, Line,
  BarChart, Bar,
  XAxis, YAxis, CartesianGrid, Tooltip, Legend, ResponsiveContainer
} from 'recharts';
import '../styles/currency-chart.less';

const currencies = ['AUD', 'USD', 'EUR', 'GBP', 'JPY'];

function CurrencyChart({ chartType = 'line' }) {
  const [data, setData] = useState([]);

  useEffect(() => {
    const fetchRates = () => {
      axios.get('http://localhost:8000/api/currency/rates')
        .then(res => {
          const { timestamp, ...rates } = res.data;
          const entry = { time: timestamp, ...rates };
          setData(prev => [...prev.slice(-19), entry]);
        })
        .catch(console.error);
    };

    fetchRates();
    const interval = setInterval(fetchRates, 1000);
    return () => clearInterval(interval);
  }, []);

  const ChartComponent = chartType === 'bar' ? BarChart : LineChart;
  const DataComponent = chartType === 'bar' ? Bar : Line;

  return (
    <div className="currency-chart">
      <h2>Live AUD Exchange Rates ({chartType === 'bar' ? 'Histogram' : 'Line'})</h2>
      <ResponsiveContainer width="100%" height={400}>
        <ChartComponent data={data}>
          <CartesianGrid stroke="#ccc" />
          <XAxis dataKey="time" />
          <YAxis domain={['auto', 'auto']} />
          <Tooltip />
          <Legend />
          {currencies.map((cur, i) => (
            <DataComponent
              key={cur}
              type="monotone"
              dataKey={cur}
              stroke={chartType === 'line' ? (cur === 'AUD' ? '#000' : `hsl(${i * 60}, 70%, 50%)`) : undefined}
              fill={chartType === 'bar' ? (cur === 'AUD' ? '#000' : `hsl(${i * 60}, 70%, 50%)`) : undefined}
              strokeDasharray={chartType === 'line' && cur === 'AUD' ? '5 5' : undefined}
              strokeWidth={chartType === 'line' && cur === 'AUD' ? 3 : 2}
              dot={chartType === 'line' ? false : undefined}
            />
          ))}
        </ChartComponent>
      </ResponsiveContainer>
    </div>
  );
}

export default CurrencyChart;
